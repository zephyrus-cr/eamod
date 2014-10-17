/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/char/int_elemental.h                                             *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena, Athena, eAthena                                          *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/ 

#ifndef _INT_ELEMENTAL_SQL_H_
#define _INT_ELEMENTAL_SQL_H_

struct s_elemental;

void inter_elemental_sql_init(void);
void inter_elemental_sql_final(void);
int inter_elemental_parse_frommap(int fd);

bool mapif_elemental_delete(int ele_id);

#endif /* _INT_ELEMENTAL_SQL_H_ */
