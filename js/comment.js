flag=0

function toiminto(let)
{
var story = document.tex.texarea.value
if(let=="BACK"){
story=story.substring(0, story.length-1)
document.tex.texarea.value=story
document.tex.texarea.focus()
}

else if(flag==1)
{
story+=let.toUpperCase()
flag=0
document.tex.texarea.value=story
document.tex.texarea.focus()
}
else
{
story+=let
flag=0
document.tex.texarea.value=story
document.tex.texarea.focus()
}
}
function capIt()
{
flag=1
}

var copytoclip=1

function HighlightAll(theField) {
var tempval=eval("document."+theField)
tempval.focus()
tempval.select()

if (document.all&&copytoclip==1){

therange=tempval.createTextRange()

therange.execCommand("Copy")

window.status="Je nickname staat nu in het geheugen. Plak het dmv Ctrl+V"

setTimeout("window.status=''",1800)

}
}