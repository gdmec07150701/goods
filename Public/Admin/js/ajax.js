function loadCompany(companyId) {
    $.post(ajaxurl,function(data){
        if(companyId!='null'){
            $.each(data,function(no,items){
               $("<option value='"+items.id+"'>"+items.title+"</option>").appendTo("#"+companyId);
            });
			$("#"+companyId).selectpicker('refresh');
        }
    });
}

function loadMeshpoint(cid,meshpointId) {
    $.post(ajaxurl,{'cid':cid},function(data){
        if(meshpointId!='null'){
            $.each(data,function(no,items){
				$("<option value='"+items.id+"'>"+items.title+"</option>").appendTo("#"+meshpointId);
            });
			$("#"+meshpointId).selectpicker('refresh');
        }
    });
}