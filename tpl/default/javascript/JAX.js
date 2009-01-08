function popUp(URL,width,height)
{
  day = new Date();
  id = day.getTime();
  eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=' + width + ',height=' + height);");
}

function do_delete(url,msg)
{
  var agree=confirm(msg);
  if (agree)
  {
    location = url;
  }
}

