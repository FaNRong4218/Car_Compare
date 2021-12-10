$(function(){

    //กำหนดตัวแปร
    var brandObject = $('#brand');
    var modelObject = $('#model');
    var yearObject =  $('#year');
   
    brandObject.on('change', function(){
        var modelId = $(this).val();
        
        modelObject.html('<option value="">เลือกรุ่นรถ</option>');
        yearObject.html('<option value="">เลือกปี</option>');
        
        $.get('getModel.php?brand=' + modelId, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                modelObject.append(
                    $('<option></option>').val(item.id).html(item.Name)
                );
            });
        });
    });
    modelObject.on('change', function(){
        
        
        yearObject.html('<option value="">เลือกปี</option>');
        
        $.get('getYear.php?', function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                yearObject.append(
                    $('<option></option>').val(item.Year_Name).html(item.Year_Name)
                );
            });
        });
    });
  
});