function xheditor_int(){
$("textarea[name='content']").xheditor(false)
$("textarea[name='content[]']").xheditor(false)
$("textarea[name='content']").xheditor({tools:'simple',height:'300',html5Upload:false,upMultiple:5,upImgUrl:xheditor_up_url,upImgExt:'jpg,jpeg,gif,png'});
$("textarea[name='content[]']").xheditor({tools:'simple',height:'300',html5Upload:false,upMultiple:5,upImgUrl:xheditor_up_url,upImgExt:'jpg,jpeg,gif,png'});
}
xheditor_int();