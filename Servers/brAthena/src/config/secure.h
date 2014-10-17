/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/config/secure.h                                                  *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena, rAthena                                                  *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/

#ifndef _CONFIG_SECURE_H_
#define _CONFIG_SECURE_H_

/**
 * Tempo de habilitação no diálogo para npcs.
 * Quando habilitado, todos os diálogos com npcs são desabilitados conforme número de segundos.
 * - ? : Tempo em segundos (ex: 10)
 * - 0 : Disabilitado
 **/
#define SECURE_NPCTIMEOUT 0

/**
 * Tempo de intervalo no diálogo para npcs.
 * Default: 1s
 **/
#define SECURE_NPCTIMEOUT_INTERVAL 1

#endif // _CONFIG_SECURE_H_
