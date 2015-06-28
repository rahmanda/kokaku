function Utils() {

}

Utils.prototype.setGetParameter = function(paramName, paramValue)
{
    var url = window.location.href;
    if (url.indexOf(paramName + "=") >= 0)
    {
        var prefix = url.substring(0, url.indexOf(paramName));
        var suffix = url.substring(url.indexOf(paramName));
        suffix = suffix.substring(suffix.indexOf("=") + 1);
        suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
        url = prefix + paramName + "=" + paramValue + suffix;
    }
    else
    {
    if (url.indexOf("?") < 0)
        url += "?" + paramName + "=" + paramValue;
    else
        url += "&" + paramName + "=" + paramValue;
    }
    window.location.href = url;
}

Utils.prototype.checkParemeterExists = function(parameter)
{
   //Get Query String from url
   fullQString = window.location.search.substring(1);
   
   paramCount = 0;
   queryStringComplete = "?";

   if(fullQString.length > 0)
   {
       //Split Query String into separate parameters
       paramArray = fullQString.split("&");
       
       //Loop through params, check if parameter exists.  
       for (i=0;i<paramArray.length;i++)
       {
         currentParameter = paramArray[i].split("=");
         if(currentParameter[0] == parameter) //Parameter already exists in current url
         {
            return true;
         }
       }
   }
   
   return false;
}

Utils.prototype.isContainNoHTML = function(el) {
  return !$.trim(el.html());
}