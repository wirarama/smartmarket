/* global parseInt */

$("#addProduct").click(function(){
    $("#addFormHere").append($("#addForm").html());
});
$(document).on("click",".delRow", function() {
    $(this).parent().parent().parent().parent().detach();
    calcTotal();
});
$(document).on("change",".selProd", function() {
    var res = $(this).val().split(',');
    $(this).parent().next().html(toRp(res[2]));
    var har = parseInt(res[2]);
    var num = parseInt($(this).parent().next().next().children().val());
    var total = har*num;
    $(this).parent().next().next().next().text(toRp(total));
    $(this).parent().next().next().next().next().text(total);
    calcTotal();
});
function calcTotal(){
    var sum = 0;
    $('.totalSemua').each(function(){ sum += parseInt($(this).text()); });
    $('#totalFinal').html('<h1>Total : '+toRp(sum)+'</h1>');
}
function toRp(n){
    var rev = parseInt(n,10).toString().split('').reverse().join('');
    var rev2 = '';
    for(var i = 0;i<rev.length;i++){
        rev2 += rev[i];
        if((i+1)%3===0 && i!==(rev.length-1)){
            rev2 += '.';
        }
    }
    return 'Rp '+rev2.split('').reverse().join('');
}