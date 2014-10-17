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

#include "../common/nullpo.h"
#include "../common/strlib.h"
#include "../common/utils.h"
#include "channel.h"
#include "clif.h"
#include "itemdb.h"
#include "atcommand.h"
#include "map.h"
#include "path.h"
#include "chrif.h"
#include "vending.h"
#include "pc.h"
#include "skill.h"
#include "battle.h"
#include "log.h"
#include "achievement.h"

#include <stdio.h>
#include <string.h>

static int vending_nextid = 0;

/// Returns an unique vending shop id.
static int vending_getuid(void)
{
	return vending_nextid++;
}

/*==========================================
 * Close shop
 *------------------------------------------*/
void vending_closevending(struct map_session_data* sd)
{
	nullpo_retv(sd);

	if( sd->state.vending )
	{
		sd->state.vending = false;
		sd->vend_coin = battle_config.vending_zeny_id;
		clif_closevendingboard(&sd->bl, 0);

		if( map[sd->bl.m].flag.vending_cell ) // Cell becomes available again.
			map_setcell(sd->bl.m, sd->bl.x, sd->bl.y, CELL_NOBOARDS, true);
	}
}

/*==========================================
 * Request a shop's item list
 *------------------------------------------*/
void vending_vendinglistreq(struct map_session_data* sd, int id)
{
	struct map_session_data* vsd;
	nullpo_retv(sd);

	if( (vsd = map_id2sd(id)) == NULL )
		return;
	if( !vsd->state.vending )
		return; // not vending
	if( !battle_config.faction_allow_vending && vsd->status.faction_id != sd->status.faction_id )
	{
		clif_displaymessage(sd->fd,"You cannot purchase from other faction members.");
		return;
	}

	if ( !pc_can_give_items(pc_isGM(sd)) || !pc_can_give_items(pc_isGM(vsd)) ) //check if both GMs are allowed to trade
	{	// GM is not allowed to trade
		clif_displaymessage(sd->fd, msg_txt(246));
		return;
	} 

	sd->vended_id = vsd->vender_id;  // register vending uid
	if( battle_config.vending_zeny_id && vsd->vend_coin )
	{ // Extended Vending System
		char output[256];
		sprintf(output,msg_txt(914),itemdb_jname(vsd->vend_coin));
		clif_displaymessage(sd->fd,output);
	}

	clif_vendinglist(sd, id, vsd->vending);
}

/*==========================================
 * Purchase item(s) from a shop
 *------------------------------------------*/
void vending_purchasereq(struct map_session_data* sd, int aid, int uid, const uint8* data, int count)
{
	int i, j, cursor, w, new_ = 0, blank, vend_list[MAX_VENDING];
	double z;
	struct s_vending vending[MAX_VENDING]; // against duplicate packets
	struct map_session_data* vsd = map_id2sd(aid);
	char output[256];

	nullpo_retv(sd);
	if( vsd == NULL || !vsd->state.vending || vsd->bl.id == sd->bl.id )
		return; // invalid shop

	if( vsd->vender_id != uid )
	{// shop has changed
		clif_buyvending(sd, 0, 0, 6);  // store information was incorrect
		return;
	}

	if( !searchstore_queryremote(sd, aid) && ( sd->bl.m != vsd->bl.m || !check_distance_bl(&sd->bl, &vsd->bl, AREA_SIZE) ) )
		return; // shop too far away

	searchstore_clearremote(sd);

	if( count < 1 || count > MAX_VENDING || count > vsd->vend_num )
		return; // invalid amount of purchased items

	blank = pc_inventoryblank(sd); //number of free cells in the buyer's inventory

	// duplicate item in vending to check hacker with multiple packets
	memcpy(&vending, &vsd->vending, sizeof(vsd->vending)); // copy vending list

	// some checks
	z = 0.; // zeny counter
	w = 0;  // weight counter
	for( i = 0; i < count; i++ )
	{
		short amount = *(uint16*)(data + 4*i + 0);
		short idx    = *(uint16*)(data + 4*i + 2);
		idx -= 2;

		if( amount <= 0 )
			return;

		// check of item index in the cart
		if( idx < 0 || idx >= MAX_CART )
			return;

		ARR_FIND( 0, vsd->vend_num, j, vsd->vending[j].index == idx );
		if( j == vsd->vend_num )
			return; //picked non-existing item
		else
			vend_list[i] = j;

		z += ((double)vsd->vending[j].value * (double)amount);
		if( !vsd->vend_coin || vsd->vend_coin == battle_config.vending_zeny_id )
		{ // Normal Vending - Zeny Option
			if( z > (double)sd->status.zeny || z < 0. || z > (double)MAX_ZENY )
			{
				clif_buyvending(sd, idx, amount, 1); // you don't have enough zeny
				return;
			}
			if( z + (double)vsd->status.zeny > (double)MAX_ZENY && !battle_config.vending_over_max )
			{
				clif_buyvending(sd, idx, vsd->vending[j].amount, 4); // too much zeny = overflow
				return;
			}
		}
		else if( battle_config.vending_cash_id && vsd->vend_coin == battle_config.vending_cash_id )
		{ // Cash Shop
			if( z > (double)sd->cashPoints || z < 0. || z > (double)MAX_ZENY )
			{
				sprintf(output,msg_txt(915),itemdb_jname(vsd->vend_coin));
				clif_displaymessage(sd->fd,output);
				return;
			}
			if( z + (double)vsd->cashPoints > (double)MAX_ZENY && !battle_config.vending_over_max )
			{
				sprintf(output,msg_txt(916),itemdb_jname(vsd->vend_coin));
				clif_displaymessage(sd->fd,output);
				return;
			}
		}

		w += itemdb_weight(vsd->status.cart[idx].nameid) * amount;
		if( w + sd->weight > sd->max_weight )
		{
			clif_buyvending(sd, idx, amount, 2); // you can not buy, because overweight
			return;
		}
		
		//Check to see if cart/vend info is in sync.
		if( vending[j].amount > vsd->status.cart[idx].amount )
			vending[j].amount = vsd->status.cart[idx].amount;
		
		// if they try to add packets (example: get twice or more 2 apples if marchand has only 3 apples).
		// here, we check cumulative amounts
		if( vending[j].amount < amount )
		{
			// send more quantity is not a hack (an other player can have buy items just before)
			clif_buyvending(sd, idx, vsd->vending[j].amount, 4); // not enough quantity
			return;
		}
		
		vending[j].amount -= amount;

		switch( pc_checkadditem(sd, vsd->status.cart[idx].nameid, amount) ) {
		case ADDITEM_EXIST:
			break;	//We'd add this item to the existing one (in buyers inventory)
		case ADDITEM_NEW:
			new_++;
			if (new_ > blank)
				return; //Buyer has no space in his inventory
			break;
		case ADDITEM_OVERAMOUNT:
			return; //too many items
		}
	}

	// Payments
	if( !vsd->vend_coin || vsd->vend_coin == battle_config.vending_zeny_id )
	{
		log_zeny(vsd, LOG_TYPE_VENDING, sd, (int)z); //Logs (V)ending Zeny [Lupus]
		pc_payzeny(sd, (int)z);
		achievement_validate_zeny(sd,ATZ_USE_VENDING,(int)z);

		if( battle_config.vending_tax || (vsd->state.autotrade && battle_config.at_tax && !pc_isPremium(vsd)) )
			z -= z * ((battle_config.vending_tax + ((vsd->state.autotrade && !pc_isPremium(vsd)) ? battle_config.at_tax : 0)) / 10000.);

		pc_getzeny(vsd, (int)z);
		achievement_validate_zeny(vsd,ATZ_GET_VENDING,(int)z);
	}
	else if( battle_config.vending_cash_id && vsd->vend_coin == battle_config.vending_cash_id )
	{
		pc_paycash(sd,(int)z,0);
		pc_getcash(vsd,(int)z,0);
	}
	else
	{
		if( z < 0. || (i = pc_search_inventory(sd,vsd->vend_coin)) < 0 || z > (double)sd->status.inventory[i].amount )
		{
			sprintf(output,msg_txt(915),itemdb_jname(vsd->vend_coin));
			clif_displaymessage(sd->fd,output);
			return;
		}

		switch( pc_checkadditem(vsd,vsd->vend_coin,(int)z) )
		{
		case ADDITEM_NEW:
			if( pc_inventoryblank(vsd) > 0 )
				break;
		case ADDITEM_OVERAMOUNT:
			sprintf(output,msg_txt(916),itemdb_jname(vsd->vend_coin));
			clif_displaymessage(sd->fd,output);
			return;
		}

		pc_additem(vsd,&sd->status.inventory[i],(int)z,LOG_TYPE_VENDING);
		pc_delitem(sd,i,(int)z,0,6,LOG_TYPE_VENDING);
	}

	for( i = 0; i < count; i++ )
	{
		short amount = *(uint16*)(data + 4*i + 0);
		short idx    = *(uint16*)(data + 4*i + 2);
		idx -= 2;

		// vending item
		pc_additem(sd, &vsd->status.cart[idx], amount, LOG_TYPE_VENDING);
		vsd->vending[vend_list[i]].amount -= amount;
		pc_cart_delitem(vsd, idx, amount, 0, LOG_TYPE_VENDING);
		clif_vendingreport(vsd, idx, amount);

		//print buyer's name
		if( battle_config.buyer_name )
		{
			char temp[256];
			sprintf(temp, msg_txt(265), sd->status.name);
			clif_disp_onlyself(vsd,temp,strlen(temp));
		}
	}

	// compact the vending list
	for( i = 0, cursor = 0; i < vsd->vend_num; i++ )
	{
		if( vsd->vending[i].amount == 0 )
			continue;
		
		if( cursor != i ) // speedup
		{
			vsd->vending[cursor].index = vsd->vending[i].index;
			vsd->vending[cursor].amount = vsd->vending[i].amount;
			vsd->vending[cursor].value = vsd->vending[i].value;
		}

		cursor++;
	}
	vsd->vend_num = cursor;

	//Always save BOTH: buyer and customer
	if( save_settings&2 )
	{
		chrif_save(sd,0);
		chrif_save(vsd,0);
	}

	//check for @AUTOTRADE users [durf]
	if( vsd->state.autotrade )
	{
		//see if there is anything left in the shop
		ARR_FIND( 0, vsd->vend_num, i, vsd->vending[i].amount > 0 );
		if( i == vsd->vend_num )
		{
			//Close Vending (this was automatically done by the client, we have to do it manually for autovenders) [Skotlex]
			vending_closevending(vsd);
			map_quit(vsd);	//They have no reason to stay around anymore, do they?
		}
	}
}

/*==========================================
 * Open shop
 * data := {<index>.w <amount>.w <value>.l}[count]
 *------------------------------------------*/
void vending_openvending(struct map_session_data* sd, const char* message, bool flag, const uint8* data, int count)
{
	int i, j, char_id;
	int vending_skill_lvl;
	nullpo_retv(sd);

	if( !flag ) // cancelled
		return; // nothing to do

	if (pc_istrading(sd))
		return; // can't have 2 shops at once

	vending_skill_lvl = pc_checkskill(sd, MC_VENDING);
	// skill level and cart check
	if( !vending_skill_lvl || !pc_iscarton(sd) )
	{
		clif_skill_fail(sd, MC_VENDING, USESKILL_FAIL_LEVEL, 0);
		return;
	}

	// check number of items in shop
	if( count < 1 || count > MAX_VENDING || count > 2 + vending_skill_lvl )
	{	// invalid item count
		clif_skill_fail(sd, MC_VENDING, USESKILL_FAIL_LEVEL, 0);
		return;
	}

	// filter out invalid items
	i = 0;
	for( j = 0; j < count; j++ )
	{
		short index        = *(uint16*)(data + 8*j + 0);
		short amount       = *(uint16*)(data + 8*j + 2);
		unsigned int value = *(uint32*)(data + 8*j + 4);

		index -= 2; // offset adjustment (client says that the first cart position is 2)

		if( index < 0 || index >= MAX_CART // invalid position
		||  pc_cartitem_amount(sd, index, amount) < 0 // invalid item or insufficient quantity
		//NOTE: official server does not do any of the following checks!
		||  !sd->status.cart[index].identify // unidentified item
		||  sd->status.cart[index].attribute == 1 // broken item
		||  sd->status.cart[index].expire_time // It should not be in the cart but just in case
		||  sd->status.cart[index].bound // Can't Trade Account bound items
		||  ( sd->status.cart[index].card[0] == CARD0_CREATE && (char_id = MakeDWord(sd->status.cart[index].card[2],sd->status.cart[index].card[3])) > 0 && ((battle_config.bg_reserved_char_id && char_id == battle_config.bg_reserved_char_id) || (battle_config.ancient_reserved_char_id && char_id == battle_config.ancient_reserved_char_id)) )
		||  !itemdb_cantrade(&sd->status.cart[index], pc_isGM(sd), pc_isGM(sd)) ) // untradeable item
			continue;

		sd->vending[i].index = index;
		sd->vending[i].amount = amount;
		sd->vending[i].value = cap_value(value, 0, (unsigned int)battle_config.vending_max_value);

		i++; // item successfully added
	}

	if( i != j )
		clif_displaymessage (sd->fd, msg_txt(266)); //"Some of your items cannot be vended and were removed from the shop."

	if( i == 0 )
	{	// no valid item found
		clif_skill_fail(sd, MC_VENDING, USESKILL_FAIL_LEVEL, 0); // custom reply packet
		return;
	}

	sd->state.vending = true;
	sd->vender_id = vending_getuid();
	sd->vend_num = i;
	safestrncpy(sd->message, message, MESSAGE_SIZE);

	pc_stop_walking(sd,1);
	clif_openvending(sd,sd->bl.id,sd->vending);
	clif_showvendingboard(&sd->bl,message,0);

	if( battle_config.channel_announces&16 && server_channel[CHN_VENDING] )
	{
		char chat_message[256];
		sprintf(chat_message, msg_txt(820), server_channel[CHN_VENDING]->name, sd->status.name, sd->message, map[sd->bl.m].name, sd->bl.x, sd->bl.y);
		clif_channel_message(server_channel[CHN_VENDING], chat_message, 27);
	}

	if( map[sd->bl.m].flag.vending_cell )
		map_setcell(sd->bl.m, sd->bl.x, sd->bl.y, CELL_NOBOARDS, false);
}

/// Checks if an item is being sold in given player's vending.
bool vending_search(struct map_session_data* sd, unsigned short nameid)
{
	int i;

	if( !sd->state.vending )
	{// not vending
		return false;
	}

	ARR_FIND( 0, sd->vend_num, i, sd->status.cart[sd->vending[i].index].nameid == (short)nameid );
	if( i == sd->vend_num )
	{// not found
		return false;
	}

	return true;
}


/// Searches for all items in a vending, that match given ids, price and possible cards.
/// @return Whether or not the search should be continued.
bool vending_searchall(struct map_session_data* sd, const struct s_search_store_search* s)
{
	int i, c, slot;
	unsigned int idx, cidx;
	struct item* it;

	if( !sd->state.vending )
	{// not vending
		return true;
	}

	for( idx = 0; idx < s->item_count; idx++ )
	{
		ARR_FIND( 0, sd->vend_num, i, sd->status.cart[sd->vending[i].index].nameid == (short)s->itemlist[idx] );
		if( i == sd->vend_num )
		{// not found
			continue;
		}
		it = &sd->status.cart[sd->vending[i].index];

		if( s->min_price && s->min_price > sd->vending[i].value )
		{// too low price
			continue;
		}

		if( s->max_price && s->max_price < sd->vending[i].value )
		{// too high price
			continue;
		}

		if( s->card_count )
		{// check cards
			if( itemdb_isspecial(it->card[0]) )
			{// something, that is not a carded
				continue;
			}
			slot = itemdb_slot(it->nameid);

			for( c = 0; c < slot && it->card[c]; c ++ )
			{
				ARR_FIND( 0, s->card_count, cidx, s->cardlist[cidx] == it->card[c] );
				if( cidx != s->card_count )
				{// found
					break;
				}
			}

			if( c == slot || !it->card[c] )
			{// no card match
				continue;
			}
		}

		if( !searchstore_result(s->search_sd, sd->vender_id, sd->status.account_id, sd->message, it->nameid, sd->vending[i].amount, sd->vending[i].value, it->card, it->refine) )
		{// result set full
			return false;
		}
	}

	return true;
}