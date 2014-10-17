/*
Ceres Control Panel

This is a control pannel program for Athena and Freya
Copyright (C) 2005 by Beowulf and Nightroad

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

To contact any of the authors about special permissions send
an e-mail to cerescp@gmail.com
*/

function LINK_ajax(http, div_name) { //função para links

	var LINK_xmlhttp = false;

	try { LINK_xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); }
	catch (e) { try { LINK_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	catch (e) { try { LINK_xmlhttp = new XMLHttpRequest(); }
	catch (e) { LINK_xmlhttp = false; }}}
	if (!LINK_xmlhttp) return null;
	
	document.getElementById('load_div').style.visibility="visible";

	LINK_xmlhttp.open("GET", http, true);

	LINK_xmlhttp.onreadystatechange = function() {
		if (LINK_xmlhttp.readyState == 4) {
			document.getElementById('load_div').style.visibility="hidden";

			if (LINK_xmlhttp.responseText.indexOf("<script type=\"text/javascript\">") > -1) {
				var x = LINK_xmlhttp.responseText.indexOf("<script type=\"text/javascript\">") + "<script type=\"text/javascript\">".length;
				var y = LINK_xmlhttp.responseText.indexOf("</script>") - x;
				eval(LINK_xmlhttp.responseText.substr(x, y));
			}

			if (LINK_xmlhttp.responseText.indexOf('ALERT|') > -1) {
				var x = LINK_xmlhttp.responseText.indexOf('ALERT|') + "ALERT|".length;
				var y = LINK_xmlhttp.responseText.indexOf('|ENDALERT') - x;
				window.alert(LINK_xmlhttp.responseText.substr(x , y));
			} else
				document.getElementById(div_name).innerHTML = LINK_xmlhttp.responseText + ' ';
		}
	}

	LINK_xmlhttp.send(null);  

	return false;
}

function POST_ajax(http, div_name, frm_name) { //função para posts

	var POST_xmlhttp = false;
	var frm = false
	var url = "";


	try { POST_xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); }
	catch (e) { try { POST_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	catch (e) { try { POST_xmlhttp = new XMLHttpRequest(); }
	catch (e) { POST_xmlhttp = false; }}}
	if (!POST_xmlhttp) return null;

	frm = document.getElementById(frm_name);

	document.getElementById('load_div').style.visibility="visible";

	url = "frm_name=" + frm_name;

	for (i = 0; i < frm.elements.length; i++) {
		frm.elements[i].disabled = true;
		if (frm.elements[i].type == "checkbox") {
			if (frm.elements[i].checked)
				frm.elements[i].value = 1;
			else
				frm.elements[i].value = 0;
		}
		url = url + "&" + frm.elements[i].name + "=" + escape(frm.elements[i].value);
	}


	POST_xmlhttp.open("POST", http, true);

	POST_xmlhttp.onreadystatechange = function() {
		if (POST_xmlhttp.readyState == 4) {
			document.getElementById('load_div').style.visibility="hidden";

			for (i = 0; i < frm.elements.length; i++) {
				if (frm.elements[i].type == "checkbox")
					frm.elements[i].checked = false;
				if (frm.elements[i].type == "password")
					frm.elements[i].value = "";
				frm.elements[i].disabled = false;
			}

			if (POST_xmlhttp.responseText.indexOf("<script type=\"text/javascript\">") > -1) {
				var x = POST_xmlhttp.responseText.indexOf("<script type=\"text/javascript\">") + "<script type=\"text/javascript\">".length;
				var y = POST_xmlhttp.responseText.indexOf("</script>") - x;
				eval(POST_xmlhttp.responseText.substr(x, y));
			}

			if (POST_xmlhttp.responseText.indexOf('ALERT|') > -1) {
				var x = POST_xmlhttp.responseText.indexOf('ALERT|') + "ALERT|".length;
				var y = POST_xmlhttp.responseText.indexOf('|ENDALERT') - x;
				window.alert(POST_xmlhttp.responseText.substr(x , y));
			} else
				document.getElementById(div_name).innerHTML = POST_xmlhttp.responseText + ' ';
		}
	}

	POST_xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	POST_xmlhttp.setRequestHeader("Content-length", url.length);
	POST_xmlhttp.setRequestHeader("Connection", "close");
	POST_xmlhttp.send(url);  

	return false;
}

function GET_ajax(http, div_name, frm_name) { //função para gets

	var GET_xmlhttp = false;
	var frm = false
	var url = "";

	
	try { GET_xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); }
	catch (e) { try { GET_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
	catch (e) { try { GET_xmlhttp = new XMLHttpRequest(); }
	catch (e) { GET_xmlhttp = false; }}}
	if (!GET_xmlhttp) return null;
	
	frm = document.getElementById(frm_name);

	document.getElementById('load_div').style.visibility="visible";

	url = http + "?frm_name=" + frm_name;

	for (i = 0; i < frm.elements.length; i++) {
		frm.elements[i].disabled = true;
		if (frm.elements[i].type == "checkbox") {
			if (frm.elements[i].checked)
				frm.elements[i].value = 1;
			else
				frm.elements[i].value = 0;
		}
		url = url + "&" + frm.elements[i].name + "=" + escape(frm.elements[i].value);
	}


	GET_xmlhttp.open("GET", url, true);
	
	GET_xmlhttp.onreadystatechange = function() {
		if (GET_xmlhttp.readyState == 4) {
			document.getElementById('load_div').style.visibility="hidden";

			for (i = 0; i < frm.elements.length; i++) {
				if (frm.elements[i].type == "checkbox")
					frm.elements[i].checked = false;
				if (frm.elements[i].type == "password")
					frm.elements[i].value = "";

				frm.elements[i].disabled = false;
			}
	
			if (GET_xmlhttp.responseText.indexOf("<script type=\"text/javascript\">") > -1) {
				var x = GET_xmlhttp.responseText.indexOf("<script type=\"text/javascript\">") + "<script type=\"text/javascript\">".length;
				var y = GET_xmlhttp.responseText.indexOf("</script>") - x;
				eval(GET_xmlhttp.responseText.substr(x, y));
			}
			
			if (GET_xmlhttp.responseText.indexOf('ALERT|') > -1) {
				var x = GET_xmlhttp.responseText.indexOf('ALERT|') + "ALERT|".length;
				var y = GET_xmlhttp.responseText.indexOf('|ENDALERT') - x;
				window.alert(GET_xmlhttp.responseText.substr(x , y));
			} else
				document.getElementById(div_name).innerHTML = GET_xmlhttp.responseText + ' ';
		}
	}

	GET_xmlhttp.send(null);  

	return false;
}

function server_status() {
	LINK_ajax('server_status.php','status_div');

	setTimeout("server_status()", 120000);
}

function login_hide(x_y) {
	if (x_y == 1)
		document.getElementById('new_div').style.visibility = "visible";
	else if (x_y == 0)
		document.getElementById('new_div').style.visibility = "hidden";
	else if (x_y == 2)
		LINK_ajax('middle.php', 'new_div');
}

function load_menu() {
	var script = document.getElementById('menu_script');
	
	if (script) {
		script.parentNode.removeChild(script);
	}

	script = document.createElement('script');
	script.id = "menu_script";
	script.type = "text/javascript" 
	script.src = "menu.php?rand=" + Math.random();

	var head = document.getElementsByTagName('HEAD')[0];
	head.appendChild(script);
}

function force(item_name, frm_name, e) {
	var keynum;

	if (window.event)
		keynum = e.keyCode;
	else if (e.which)
		keynum = e.which;

	if (keynum == 13) {
		var frm = false;
		var i = 0;
		var j = 0;

		frm = document.getElementById(frm_name);

		for (i = 0; i < frm.elements.length; i++) {
			if (item_name == frm.elements[i].name) {
				if (frm.elements[i + 1].type == "submit") {
					for (j = 0; j < frm.elements.length; j++) {
						if (frm.elements[j].type == "checkbox")
							continue;
						if (frm.elements[j].value == '') {
							frm.elements[j].focus();
							return false;
						}
					}
				}
				while (frm.elements[i + 1]) {
					if (frm.elements[i + 1].type != "hidden") {
						frm.elements[i + 1].focus();
						return false;
					}
					i++;
				}
			}
		}
	}
	return true;
}
