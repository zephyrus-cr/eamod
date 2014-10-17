/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/common/grfio.h                                                   *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena, Athena                                                   *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/

#ifndef _GRFIO_H_
#define _GRFIO_H_

void grfio_init(const char *fname);
void grfio_final(void);
void *grfio_reads(const char *fname, int *size);
char *grfio_find_file(const char *fname);
#define grfio_read(fn) grfio_reads(fn, NULL)

unsigned long grfio_crc32(const unsigned char *buf, unsigned int len);
int decode_zip(void *dest, unsigned long *destLen, const void *source, unsigned long sourceLen);
int encode_zip(void *dest, unsigned long *destLen, const void *source, unsigned long sourceLen);

#endif /* _GRFIO_H_ */
