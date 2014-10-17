/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/login/loginlog.h                                                 *
* Declarações de Logs do Servidor de Entrada (Login).                        *
* Códigos de declaração para loginlog_sql.c                                  *
* \author brAthena, Athena, eAthena                                          *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/ 

#ifndef __LOGINLOG_H_INCLUDED__
#define __LOGINLOG_H_INCLUDED__


unsigned long loginlog_failedattempts(uint32 ip, unsigned int minutes);
void login_log(uint32 ip, const char *username, int rcode, const char *message);
bool loginlog_init(void);
bool loginlog_final(void);
bool loginlog_config_read(const char *w1, const char *w2);


#endif // __LOGINLOG_H_INCLUDED__
