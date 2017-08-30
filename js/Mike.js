$(function() {
    
        let filter = { price: undefined, categorie: undefined };
    
    
        function singleItem() {
            $.ajax({
                url: "http://localhost/php-object-webforce3/single/" + idItem,
                method: "POST"
            }).done(function(data) {
    
                data = JSON.parse(data);
                console.log(data);
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
    
        function shopListItem() {
    
            /* Bug si drop en dehors de la span */
            $("span.ui-slider-handle.ui-state-default.ui-corner-all").mouseup(function() {
    
                console.log("Al ne va pas comprendre");
                filter.price = $("#amount").val();
                filter.price = filter.price.replace("$", "");
                filter.price = filter.price.replace("$", "");
                filter.price = filter.price.replace("-", "and");
                runFilter()
            })
    
            $("li.shop-categories-item").click(function() {
    
                console.log($(this).attr("id").split("-")[1])
                filter.categorie = $(this).attr("id").split("-")[1];
                runFilter()
    
            });

           
    
            function runFilter() {
                $.ajax({
                    url: "http://localhost/php-object-webforce3/shop-list",
                    method: "POST",
                    data: filter
                }).done(function(data) {
                    data = JSON.parse(data);
                    $("div.shop-list").html("");
                    //console.log(window.location)
                    for (var i = 0; i < data.length; i++) {
                        var html = "<div class='grid-item2 mb30'>  <div class='row'>  <div class='arrival-overlay col-md-4'> <a href='" + hostDomaine + "single/" + data[i].iditems + "'> <img src='"+data[i].url+"' alt=''> </a> </div>  <div class='col-md-8'> <div class='list-content'>  <h1> <a href='" + hostDomaine + "single/" + data[i].iditems + "'> " + data[i].libelle + " </a> </h1>  <div class='list-midrow'>  <ul> <li><span class='low-price'>" + data[i].price + "€</span></li> </ul>  <img src='upload/stars.png' alt=''>  <div class='reviews'><a href='#'>21 Rewiew(s)</a> / <a href='#'>Add a Review</a></div> <div class='clear'></div> </div>  <p class='list-desc'>" + data[i].description + "</p>  <div class='list-downrow'>  <a href='#' class='medium-button button-red add-cart' id='items-" + data[i].iditems + "'>Add to Cart</a>  <ul> <li><a href='#' class='wishlist'><i class='fa fa-heart'></i> Add to Wishlist</a></li> <li><a href='#' class='compare'><i class='fa fa-retweet'></i>Add to Compare</a></li> </ul> <div class='clear'></div>    </div>  </div> </div>  </div>  </div>";
                        
                        $("div.shop-list").append(html);
                        $("a#items-" + data[i].iditems + ".medium-button.button-red.add-cart").data("test", data[i]);
                    }

                    $("a.medium-button.button-red.add-cart").click(function(){
                        console.log($("a.medium-button.button-red.add-cart").data());
                        //localStorage.setItem("iditem", );
                    });

                });
            }

        }
    
        switch (typePage) {
            case 1:
                singleItem()
                break;
            case 2:
                shopListItem()
                break;
            default:
                console.log("Ok")
        }
    
    });