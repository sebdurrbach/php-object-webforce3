$(function() {
    function singleItem(){
        $.ajax({
            url: "http://localhost/Mike/php-object-webforce3/single/" + idItem,
            method: "POST"
        }).done(function(data) {

            data = JSON.parse(data);

            /** Pictures **/
            $("div.sp-wrap").html("");
            for (var i = 0; i < data.pictures.length; i++)
                $("div.sp-wrap").append("<a href=" + data.pictures[i].url + "><img src=" + data.pictures[i].url + " alt=''></a>")

            /** Reviews **/
            $("#elem-reviews").text(data.reviews.length + " Rewiew(s)")
            for (var i = 0; i < data.reviews.length; i++)
                $("#tabs-3").append("<p><strong>" + data.reviews[i].username + "</strong></p><p>" + data.reviews[i].commentaire + "</p><br/>")


        }).fail(function(jqXHR, textStatus) {

        })
    }
   
    function shopListItem(){
        $.ajax({
            url: "http://localhost/Mike/php-object-webforce3/shop-list/",
            method: "POST"
            //data : {price : " 20 AND 100 "}
        }).done(function(data){
            data = JSON.parse(data);
            console.log(data);
            // $("div.grid-item2").html("");
            // for (var i = 0; i < data.price.length; i++)
            //     $("div.grid-item2").append("<a href=" + data.pictures[i].url + "><img src=" + data.pictures[i].url + " alt=''></a>")
        }).fail(function(jqXHR, textStatus) {

        })
    }

    switch (typePage){
        case 1:
            singleItem();
        break;

        case 2:
            shopListItem();
        break;

        default:
            console.log("Ok");
    }
        
   

});