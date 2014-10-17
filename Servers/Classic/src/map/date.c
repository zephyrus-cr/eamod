// (c) 2008 - 2011 eAmod Project; Andres Garbanzo / Zephyrus
//
//  - gaiaro.staff@yahoo.com
//  - MSN andresjgm.cr@hotmail.com
//  - Skype: Zephyrus_cr
//  - Site: http://dev.terra-gaming.com
//
// This file is NOT public - you are not allowed to distribute it.
// Authorized Server List : http://dev.terra-gaming.com/index.php?/topic/72-authorized-eamod-servers/
// eAmod is a non Free, extended version of eAthena Ragnarok Private Server.

#include "date.h"
#include <time.h>

int date_get_year(void)
{
	time_t t;
	struct tm * lt;
	t = time(NULL);
	lt = localtime(&t);
	return lt->tm_year+1900;
}
int date_get_month(void)
{
	time_t t;
	struct tm * lt;
	t = time(NULL);
	lt = localtime(&t);
	return lt->tm_mon+1;
}
int date_get_day(void)
{
	time_t t;
	struct tm * lt;
	t = time(NULL);
	lt = localtime(&t);
	return lt->tm_mday;
}
int date_get_hour(void)
{
	time_t t;
	struct tm * lt;
	t = time(NULL);
	lt = localtime(&t);
	return lt->tm_hour;
}

int date_get_min(void)
{
	time_t t;
	struct tm * lt;
	t = time(NULL);
	lt = localtime(&t);
	return lt->tm_min;
}

int date_get_sec(void)
{
	time_t t;
	struct tm * lt;
	t = time(NULL);
	lt = localtime(&t);
	return lt->tm_sec;
}

int is_day_of_sun(void)
{
	return date_get_day()%2 == 0;
}

int is_day_of_moon(void)
{
	return date_get_day()%2 == 1;
}

int is_day_of_star(void)
{
	return date_get_day()%5 == 0;
}
