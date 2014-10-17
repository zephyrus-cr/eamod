/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/common/nullpo.c                                                  *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena, Athena                                                   *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/

#include <stdio.h>
#include <stdarg.h>
#include <string.h>
#include "nullpo.h"
#include "../common/showmsg.h"
// #include "logs.h" // ?z????A??

static void nullpo_info_core(const char *file, int line, const char *func,
                             const char *fmt, va_list ap);

/*======================================
 * Null?`?F?b?N ?y?? ?????o??
 *--------------------------------------*/
int nullpo_chk_f(const char *file, int line, const char *func, const void *target,
                 const char *fmt, ...)
{
	va_list ap;

	if(target != NULL)
		return 0;

	va_start(ap, fmt);
	nullpo_info_core(file, line, func, fmt, ap);
	va_end(ap);
	return 1;
}

int nullpo_chk(const char *file, int line, const char *func, const void *target)
{
	if(target != NULL)
		return 0;

	nullpo_info_core(file, line, func, NULL, NULL);
	return 1;
}


/*======================================
 * nullpo?????o??(?O???do?????????b?p)
 *--------------------------------------*/
void nullpo_info_f(const char *file, int line, const char *func,
                   const char *fmt, ...)
{
	va_list ap;

	va_start(ap, fmt);
	nullpo_info_core(file, line, func, fmt, ap);
	va_end(ap);
}

void nullpo_info(const char *file, int line, const char *func)
{
	nullpo_info_core(file, line, func, NULL, NULL);
}


/*======================================
 * nullpo?????o??(Main)
 *--------------------------------------*/
static void nullpo_info_core(const char *file, int line, const char *func,
                             const char *fmt, va_list ap)
{
	if(file == NULL)
		file = "??";

	func =
	    func == NULL    ? (read_message("svn_version_mes3")):
	    func[0] == '\0' ? (read_message("svn_version_mes3")):
	    func;

	ShowMessage("--- nullpo info --------------------------------------------\n");
	ShowMessage(read_message("Source.common.nullpo_info_core"), file, line, func);
	if(fmt != NULL) {
		if(fmt[0] != '\0') {
			vprintf(fmt, ap);

			// ?O?????s???????m?F
			if(fmt[strlen(fmt)-1] != '\n')
				ShowMessage("\n");
		}
	}
	ShowMessage("--- end nullpo info ----------------------------------------\n");

	// ????????nullpo???O???t?@?C????????o??????
	// ????E??o?l??????v??A??????B
}
