/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/common/ers.c                                                     *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena, Athena                                                   *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/
#include <stdlib.h>

#include "../common/cbasetypes.h"
#include "../common/malloc.h" // CREATE, RECREATE, aMalloc, aFree
#include "../common/showmsg.h" // ShowMessage, ShowError, ShowFatalError, CL_BOLD, CL_NORMAL
#include "ers.h"

#ifndef DISABLE_ERS

#define ERS_ROOT_SIZE 256
#define ERS_BLOCK_ENTRIES 4096

struct ers_list {
	struct ers_list *Next;
};

typedef struct ers_cache {
	// Allocated object size, including ers_list size
	unsigned int ObjectSize;

	// Number of ers_instances referencing this
	int ReferenceCount;

	// Reuse linked list
	struct ers_list *ReuseList;

	// Memory blocks array
	unsigned char **Blocks;

	// Max number of blocks
	unsigned int Max;

	// Free objects count
	unsigned int Free;

	// Used objects count
	unsigned int Used;

	// Linked list
	struct ers_cache *Next, *Prev;
} ers_cache_t;

typedef struct {
	// Interface to ERS
	struct eri VTable;

	// Name, used for debbuging purpouses
	char *Name;

	// Misc options
	enum ERSOptions Options;

	// Our cache
	ers_cache_t *Cache;

	// Count of objects in use, used for detecting memory leaks
	unsigned int Count;
} ers_instance_t;


// Array containing a pointer for all ers_cache structures
static ers_cache_t *CacheList;

static ers_cache_t *ers_find_cache(unsigned int size)
{
	ers_cache_t *cache;

	for(cache = CacheList; cache; cache = cache->Next)
		if(cache->ObjectSize == size)
			return cache;

	CREATE(cache, ers_cache_t, 1);
	cache->ObjectSize = size;
	cache->ReferenceCount = 0;
	cache->ReuseList = NULL;
	cache->Blocks = NULL;
	cache->Free = 0;
	cache->Used = 0;
	cache->Max = 0;

	if(CacheList == NULL) {
		CacheList = cache;
	} else {
		cache->Next = CacheList;
		cache->Next->Prev = cache;
		CacheList = cache;
		CacheList->Prev = NULL;
	}

	return cache;
}

static void ers_free_cache(ers_cache_t *cache, bool remove)
{
	unsigned int i;

	for(i = 0; i < cache->Used; i++)
		aFree(cache->Blocks[i]);

	if(cache->Next)
		cache->Next->Prev = cache->Prev;

	if(cache->Prev)
		cache->Prev->Next = cache->Next;
	else
		CacheList = cache->Next;

	aFree(cache->Blocks);
	aFree(cache);
}

static void *ers_obj_alloc_entry(ERS self)
{
	ers_instance_t *instance = (ers_instance_t *)self;
	void *ret;

	if(instance == NULL) {
		ShowError(read_message("Source.common.ers_obj_alloc_entry"));
		return NULL;
	}

	if(instance->Cache->ReuseList != NULL) {
		ret = (void *)((unsigned char *)instance->Cache->ReuseList + sizeof(struct ers_list));
		instance->Cache->ReuseList = instance->Cache->ReuseList->Next;
	} else if(instance->Cache->Free > 0) {
		instance->Cache->Free--;
		ret = &instance->Cache->Blocks[instance->Cache->Used - 1][instance->Cache->Free * instance->Cache->ObjectSize + sizeof(struct ers_list)];
	} else {
		if(instance->Cache->Used == instance->Cache->Max) {
			instance->Cache->Max = (instance->Cache->Max * 4) + 3;
			RECREATE(instance->Cache->Blocks, unsigned char *, instance->Cache->Max);
		}

		CREATE(instance->Cache->Blocks[instance->Cache->Used], unsigned char, instance->Cache->ObjectSize * ERS_BLOCK_ENTRIES);
		instance->Cache->Used++;

		instance->Cache->Free = ERS_BLOCK_ENTRIES -1;
		ret = &instance->Cache->Blocks[instance->Cache->Used - 1][instance->Cache->Free * instance->Cache->ObjectSize + sizeof(struct ers_list)];
	}

	instance->Count++;

	return ret;
}

static void ers_obj_free_entry(ERS self, void *entry)
{
	ers_instance_t *instance = (ers_instance_t *)self;
	struct ers_list *reuse = (struct ers_list *)((unsigned char *)entry - sizeof(struct ers_list));

	if(instance == NULL) {
		ShowError(read_message("Source.common.ers_obj_alloc_entry"));
		return;
	} else if(entry == NULL) {
		ShowError(read_message("Source.common.ers_obj_free_entry"));
		return;
	}

	reuse->Next = instance->Cache->ReuseList;
	instance->Cache->ReuseList = reuse;
	instance->Count--;
}

static size_t ers_obj_entry_size(ERS self)
{
	ers_instance_t *instance = (ers_instance_t *)self;

	if(instance == NULL) {
		ShowError(read_message("Source.common.ers_obj_alloc_entry"));
		return 0;
	}

	return instance->Cache->ObjectSize;
}

static void ers_obj_destroy(ERS self)
{
	ers_instance_t *instance = (ers_instance_t *)self;

	if(instance == NULL) {
		ShowError(read_message("Source.common.ers_obj_alloc_entry"));
		return;
	}

	if(instance->Count > 0)
		if(!(instance->Options & ERS_OPT_CLEAR))
			ShowWarning(read_message("Source.common.ers_obj_destroy"), instance->Name, instance->Count);

	if(--instance->Cache->ReferenceCount <= 0)
		ers_free_cache(instance->Cache, true);

	aFree(instance);
}

ERS ers_new(uint32 size, char *name, enum ERSOptions options)
{
	ers_instance_t *instance;
	CREATE(instance, ers_instance_t, 1);

	size += sizeof(struct ers_list);
	if(size % ERS_ALIGNED)
		size += ERS_ALIGNED - size % ERS_ALIGNED;

	instance->VTable.alloc = ers_obj_alloc_entry;
	instance->VTable.free = ers_obj_free_entry;
	instance->VTable.entry_size = ers_obj_entry_size;
	instance->VTable.destroy = ers_obj_destroy;

	instance->Name = name;
	instance->Options = options;

	instance->Cache = ers_find_cache(size);
	instance->Cache->ReferenceCount++;

	instance->Count = 0;

	return &instance->VTable;
}

void ers_report(void)
{
	// FIXME: Someone use this? Is it really needed?
}

void ers_force_destroy_all(void)
{
	ers_cache_t *cache;

	for(cache = CacheList; cache; cache = cache->Next)
		ers_free_cache(cache, false);
}

#endif
