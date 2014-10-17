/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/common/conf.c                                                    *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena                                                           *
* \date ?                                                                    *
* \todo ?                                                                    *   
*****************************************************************************/ 

#include "conf.h"
#include "libconfig.h"

#include "../common/showmsg.h" // ShowError
#include <string.h> // read_message

struct brathena_config bra_config;

int conf_read_file(config_t *config, const char *config_filename)
{
	config_init(config);
	if(!config_read_file(config, config_filename)) {
		ShowError("%s:%d - %s\n", config_error_file(config),
		          config_error_line(config), config_error_text(config));
		config_destroy(config);
		return 1;
	}
	return 0;
}

//
// Functions to copy settings from libconfig/contrib
//
static void config_setting_copy_simple(config_setting_t *parent, const config_setting_t *src);
static void config_setting_copy_elem(config_setting_t *parent, const config_setting_t *src);
static void config_setting_copy_aggregate(config_setting_t *parent, const config_setting_t *src);
int config_setting_copy(config_setting_t *parent, const config_setting_t *src);

void config_setting_copy_simple(config_setting_t *parent, const config_setting_t *src)
{
	if(config_setting_is_aggregate(src)) {
		config_setting_copy_aggregate(parent, src);
	} else {
		config_setting_t *set = config_setting_add(parent, config_setting_name(src), config_setting_type(src));

		if(set == NULL)
			return;

		if(CONFIG_TYPE_INT == config_setting_type(src)) {
			config_setting_set_int(set, config_setting_get_int(src));
			config_setting_set_format(set, src->format);
		} else if(CONFIG_TYPE_INT64 == config_setting_type(src)) {
			config_setting_set_int64(set, config_setting_get_int64(src));
			config_setting_set_format(set, src->format);
		} else if(CONFIG_TYPE_FLOAT == config_setting_type(src)) {
			config_setting_set_float(set, config_setting_get_float(src));
		} else if(CONFIG_TYPE_STRING == config_setting_type(src)) {
			config_setting_set_string(set, config_setting_get_string(src));
		} else if(CONFIG_TYPE_BOOL == config_setting_type(src)) {
			config_setting_set_bool(set, config_setting_get_bool(src));
		}
	}
}

void config_setting_copy_elem(config_setting_t *parent, const config_setting_t *src)
{
	config_setting_t *set = NULL;

	if(config_setting_is_aggregate(src))
		config_setting_copy_aggregate(parent, src);
	else if(CONFIG_TYPE_INT == config_setting_type(src)) {
		set = config_setting_set_int_elem(parent, -1, config_setting_get_int(src));
		config_setting_set_format(set, src->format);
	} else if(CONFIG_TYPE_INT64 == config_setting_type(src)) {
		set = config_setting_set_int64_elem(parent, -1, config_setting_get_int64(src));
		config_setting_set_format(set, src->format);
	} else if(CONFIG_TYPE_FLOAT == config_setting_type(src)) {
		config_setting_set_float_elem(parent, -1, config_setting_get_float(src));
	} else if(CONFIG_TYPE_STRING == config_setting_type(src)) {
		config_setting_set_string_elem(parent, -1, config_setting_get_string(src));
	} else if(CONFIG_TYPE_BOOL == config_setting_type(src)) {
		config_setting_set_bool_elem(parent, -1, config_setting_get_bool(src));
	}
}

void config_setting_copy_aggregate(config_setting_t *parent, const config_setting_t *src)
{
	config_setting_t *newAgg;
	int i, n;

	newAgg = config_setting_add(parent, config_setting_name(src), config_setting_type(src));

	if(newAgg == NULL)
		return;

	n = config_setting_length(src);

	for(i = 0; i < n; i++) {
		if(config_setting_is_group(src)) {
			config_setting_copy_simple(newAgg, config_setting_get_elem(src, i));
		} else {
			config_setting_copy_elem(newAgg, config_setting_get_elem(src, i));
		}
	}
}

int config_setting_copy(config_setting_t *parent, const config_setting_t *src)
{
	if(!config_setting_is_group(parent) && !config_setting_is_list(parent))
		return CONFIG_FALSE;

	if(config_setting_is_aggregate(src)) {
		config_setting_copy_aggregate(parent, src);
	} else {
		config_setting_copy_simple(parent, src);
	}
	return CONFIG_TRUE;
}

// ----------------------------------------------------------------------------------------
// Sistema Multilinguagem
// ----------------------------------------------------------------------------------------
// read_message("Grupo.SubGrupo.String");
// ----------------------------------------------------------------------------------------
// http://www.hyperrealm.com/libconfig/libconfig_manual.html
// ----------------------------------------------------------------------------------------
char *read_message(const char *param)
{
	static char message[512];
	config_setting_t *str;
	config_t configLang;

	config_init(&configLang);

	if(!config_read_file(&configLang, (!strlen(bra_config.lang_file)?"conf/lang/pt_br.conf":bra_config.lang_file))) {
		ShowError("read_message erro: %s:%d - %s\n", config_error_file(&configLang), config_error_line(&configLang), config_error_text(&configLang));
		config_destroy(&configLang);
		return "";
	}

	if(!(str = config_lookup(&configLang, param))) {
		ShowError("read_message erro: %s\n", param);
		config_destroy(&configLang);
		return "";
	}
	
	strncpy(message, config_setting_get_string(str), sizeof(message));
	config_destroy(&configLang);
	return message;
}

// Leitura de configurações exclusivas do brAthena.
void read_brathena_config(void)
{
	const char *tmpchar;
	int tmpint;
	config_t configbrA;
	
	memset(&bra_config, 0, sizeof(bra_config));
	config_init(&configbrA);
	
	if(!config_read_file(&configbrA, "conf/battle/brathena.conf")) {
		ShowError("read_brathena_config erro: %s:%d - %s\n", config_error_file(&configbrA), config_error_line(&configbrA), config_error_text(&configbrA));
		config_destroy(&configbrA);
	}	

	if(config_lookup_int(&configbrA, "max_rename_char", &tmpint))               // Max. rename system
		bra_config.max_rename_char = tmpint;
	if(config_lookup_string(&configbrA, "lang_file", &tmpchar))                 // Server lang
		strncpy(bra_config.lang_file, tmpchar, sizeof(bra_config.lang_file));
	
	//------------------------------------------------------------------------
	// Sistema Vip Oficial
	//------------------------------------------------------------------------
	if(config_lookup_int(&configbrA, "enable_system_vip", &tmpint))
		bra_config.enable_system_vip = tmpint;
	if(config_lookup_int(&configbrA, "level_vip", &tmpint))
		bra_config.level_vip = tmpint;
	if(config_lookup_int(&configbrA, "extra_exp_vip", &tmpint))
		bra_config.extra_exp_vip = tmpint;
	if(config_lookup_int(&configbrA, "penalty_exp_vip", &tmpint))
		bra_config.penalty_exp_vip = tmpint;

	config_destroy(&configbrA);
}
