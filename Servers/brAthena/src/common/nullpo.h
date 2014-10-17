/****************************************************************************!
*                _           _   _   _                                       *    
*               | |__  _ __ / \ | |_| |__   ___ _ __   __ _                  *  
*               | '_ \| '__/ _ \| __| '_ \ / _ \ '_ \ / _` |                 *   
*               | |_) | | / ___ \ |_| | | |  __/ | | | (_| |                 *    
*               |_.__/|_|/_/   \_\__|_| |_|\___|_| |_|\__,_|                 *    
*                                                                            *
*                                                                            *
* \file src/common/nullpo.h                                                  *
* Descrição Primária.                                                        *
* Descrição mais elaborada sobre o arquivo.                                  *
* \author brAthena, Athena                                                   *
* \date ?                                                                    *
* \todo ?                                                                    *  
*****************************************************************************/

#ifndef _NULLPO_H_
#define _NULLPO_H_


#include "../common/cbasetypes.h"

#define NLP_MARK __FILE__, __LINE__, __func__

// enabled by default on debug builds
#if defined(DEBUG) && !defined(NULLPO_CHECK)
#define NULLPO_CHECK
#endif

/*----------------------------------------------------------------------------
 * Macros
 *----------------------------------------------------------------------------
 */
/*======================================
 * Null�`�F�b�N �y�� �����o�͌� return
 *�E�W�J������if�Ƃ�return�����o���̂�
 *  ���s�P�̂Ŏg��Ă��������B
 *�Enullpo_ret(x = func());
 *  �̂悤�Ȏg�p�@���z�肵�Ă��܂��B
 *--------------------------------------
 * nullpo_ret(t)
 *   �߂��l 0�Œ�
 * [����]
 *  t       �`�F�b�N�Ώ�
 *--------------------------------------
 * nullpo_retv(t)
 *   �߂��l �Ȃ�
 * [����]
 *  t       �`�F�b�N�Ώ�
 *--------------------------------------
 * nullpo_retr(ret, t)
 *   �߂��l �w��
 * [����]
 *  ret     return(ret);
 *  t       �`�F�b�N�Ώ�
 *--------------------------------------
 * nullpo_ret_f(t, fmt, ...)
 *   �ڍ׏����o�͗p
 *   �߂��l 0
 * [����]
 *  t       �`�F�b�N�Ώ�
 *  fmt ... vprintf�ɓn������
 *    ���l���֌W�ϐ��̏����o���Ȃǂ�
 *--------------------------------------
 * nullpo_retv_f(t, fmt, ...)
 *   �ڍ׏����o�͗p
 *   �߂��l �Ȃ�
 * [����]
 *  t       �`�F�b�N�Ώ�
 *  fmt ... vprintf�ɓn������
 *    ���l���֌W�ϐ��̏����o���Ȃǂ�
 *--------------------------------------
 * nullpo_retr_f(ret, t, fmt, ...)
 *   �ڍ׏����o�͗p
 *   �߂��l �w��
 * [����]
 *  ret     return(ret);
 *  t       �`�F�b�N�Ώ�
 *  fmt ... vprintf�ɓn������
 *    ���l���֌W�ϐ��̏����o���Ȃǂ�
 *--------------------------------------
 */

#if defined(NULLPO_CHECK)

#define nullpo_ret(t) \
	if (nullpo_chk(NLP_MARK, (void *)(t))) {return(0);}

#define nullpo_retv(t) \
	if (nullpo_chk(NLP_MARK, (void *)(t))) {return;}

#define nullpo_retr(ret, t) \
	if (nullpo_chk(NLP_MARK, (void *)(t))) {return(ret);}

#define nullpo_retb(t) \
	if (nullpo_chk(NLP_MARK, (void *)(t))) {break;}

// �ψ����}�N���Ɋւ�����R���p�C��
#if __STDC_VERSION__ >= 199901L
/* C99�ɑΉ� */
#define nullpo_ret_f(t, fmt, ...) \
	if (nullpo_chk_f(NLP_MARK, (void *)(t), (fmt), __VA_ARGS__)) {return(0);}

#define nullpo_retv_f(t, fmt, ...) \
	if (nullpo_chk_f(NLP_MARK, (void *)(t), (fmt), __VA_ARGS__)) {return;}

#define nullpo_retr_f(ret, t, fmt, ...) \
	if (nullpo_chk_f(NLP_MARK, (void *)(t), (fmt), __VA_ARGS__)) {return(ret);}

#define nullpo_retb_f(t, fmt, ...) \
	if (nullpo_chk_f(NLP_MARK, (void *)(t), (fmt), __VA_ARGS__)) {break;}

#elif __GNUC__ >= 2
/* GCC�p */
#define nullpo_ret_f(t, fmt, args...) \
	if (nullpo_chk_f(NLP_MARK, (void *)(t), (fmt), ## args)) {return(0);}

#define nullpo_retv_f(t, fmt, args...) \
	if (nullpo_chk_f(NLP_MARK, (void *)(t), (fmt), ## args)) {return;}

#define nullpo_retr_f(ret, t, fmt, args...) \
	if (nullpo_chk_f(NLP_MARK, (void *)(t), (fmt), ## args)) {return(ret);}

#define nullpo_retb_f(t, fmt, args...) \
	if (nullpo_chk_f(NLP_MARK, (void *)(t), (fmt), ## args)) {break;}

#else

/* ���̑��̏ꍇ�E�E�E orz */

#endif

#else /* NULLPO_CHECK */
/* No Nullpo check */

// if((t)){;}
// �ǂ����@���v�����Ȃ�����̂ŁE�E�E�����̍��ł��B
// �ꉞ���[�j���O�͏o�Ȃ��͂�

#define nullpo_ret(t) (void)(t)
#define nullpo_retv(t) (void)(t)
#define nullpo_retr(ret, t) (void)(t)
#define nullpo_retb(t) (void)(t)

// �ψ����}�N���Ɋւ�����R���p�C��
#if __STDC_VERSION__ >= 199901L
/* C99�ɑΉ� */
#define nullpo_ret_f(t, fmt, ...) (void)(t)
#define nullpo_retv_f(t, fmt, ...) (void)(t)
#define nullpo_retr_f(ret, t, fmt, ...) (void)(t)
#define nullpo_retb_f(t, fmt, ...) (void)(t)

#elif __GNUC__ >= 2
/* GCC�p */
#define nullpo_ret_f(t, fmt, args...) (void)(t)
#define nullpo_retv_f(t, fmt, args...) (void)(t)
#define nullpo_retr_f(ret, t, fmt, args...) (void)(t)
#define nullpo_retb_f(t, fmt, args...) (void)(t)

#else
/* ���̑��̏ꍇ�E�E�E orz */
#endif

#endif /* NULLPO_CHECK */

/*----------------------------------------------------------------------------
 * Functions
 *----------------------------------------------------------------------------
 */
/*======================================
 * nullpo_chk
 *   Null�`�F�b�N �y�� �����o��
 * [����]
 *  file    __FILE__
 *  line    __LINE__
 *  func    __func__ (�֐���)
 *    �������ɂ� NLP_MARK ���g���Ƃ悢
 *  target  �`�F�b�N�Ώ�
 * [�Ԃ��l]
 *  0 OK
 *  1 NULL
 *--------------------------------------
 */
int nullpo_chk(const char *file, int line, const char *func, const void *target);


/*======================================
 * nullpo_chk_f
 *   Null�`�F�b�N �y�� �ڍׂȏ����o��
 * [����]
 *  file    __FILE__
 *  line    __LINE__
 *  func    __func__ (�֐���)
 *    �������ɂ� NLP_MARK ���g���Ƃ悢
 *  target  �`�F�b�N�Ώ�
 *  fmt ... vprintf�ɓn������
 *    ���l���֌W�ϐ��̏����o���Ȃǂ�
 * [�Ԃ��l]
 *  0 OK
 *  1 NULL
 *--------------------------------------
 */
int nullpo_chk_f(const char *file, int line, const char *func, const void *target,
                 const char *fmt, ...)
__attribute__((format(printf,5,6)));


/*======================================
 * nullpo_info
 *   nullpo�����o��
 * [����]
 *  file    __FILE__
 *  line    __LINE__
 *  func    __func__ (�֐���)
 *    �������ɂ� NLP_MARK ���g���Ƃ悢
 *--------------------------------------
 */
void nullpo_info(const char *file, int line, const char *func);


/*======================================
 * nullpo_info_f
 *   nullpo�ڍ׏����o��
 * [����]
 *  file    __FILE__
 *  line    __LINE__
 *  func    __func__ (�֐���)
 *    �������ɂ� NLP_MARK ���g���Ƃ悢
 *  fmt ... vprintf�ɓn������
 *    ���l���֌W�ϐ��̏����o���Ȃǂ�
 *--------------------------------------
 */
void nullpo_info_f(const char *file, int line, const char *func,
                   const char *fmt, ...)
__attribute__((format(printf,4,5)));


#endif /* _NULLPO_H_ */
