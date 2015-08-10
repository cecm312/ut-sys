var productsCarList = [];

$(function () {
    loadCar();
    $(document).on("click", ".addtoCar", function () {
        addtoCar(this);
    });
    $(document).on("click", ".removeFromCar", function () {
        removeFromCar(this);
    });
    $(document).on("click", ".getCar", function (e) {
        e.preventDefault();
        getLayoutCar(this);
    });
    $(document).on("change", ".productCant", function () {
        calcTotalCar();
    });
    $(document).on("click", ".finishBuy", function (e) {
        e.preventDefault();
        finishBuy();
    });
    $(document).on("click", ".addNewProfile", function (e) {
        e.preventDefault();
        finishBuy();
    });
    $(document).on("click", ".addNewClient", function (e) {
        e.preventDefault();
        addNewClient();
    });
    $(document).on("submit", ".newClient", function (e) {
        e.preventDefault();
        setNewClient(this);
    });
    $(document).on("submit", ".saveOrder", function (e) {
        e.preventDefault();
        saveOrder(this);
    });
})

var saveOrder = function (form) {
    var paymethod = $(form).find("#formapago").val();
    var delivermethod = $(form).find("#formaenvio").val();
    var buyOrder = localStorage.getItem('buyOrder');
    buyOrder = JSON.parse(buyOrder);
    if (buyOrder.length > 0) {
        var data = {products: buyOrder, module: "buy_order", action: "setOrder", paymethod: paymethod, delivermethod: delivermethod};
        console.log(data);
        $.ajax({
            url: "index.php?",
            type: "POST",
            dataType: "JSON",
            data: data,
            success: function (data) {
                if (data.resultado) {
                    localStorage.removeItem("productsCarList");
                    localStorage.removeItem("buyOrder");
                    document.location = "?module=store";
                } else {
                    
                }
            }
        });
    }

}

var setNewClient = function (form) {
    var data = $(form).serializeArray();
    $.ajax({
        url: "index.php?",
        type: "POST",
        dataType: "JSON",
        data: data,
        success: function (data) {
            if (data.result) {
                location.reload();
            }

        }
    });

}

var addNewClient = function () {
    $.ajax({
        url: "index.php?",
        type: "POST",
        dataType: "JSON",
        data: {
            module: "profile",
            action: "printLayoutAddClient",
        },
        success: function (data, status) {
            $("#layout_module").html(data.html);
        }
    });
}


var finishBuy = function () {
    var buyOrder = [];
    $(".trCarProduct").each(function () {
        var cantidad = $(this).find(".productCant").val();
        var idproducto = $(this).data("idproduct");
        if (cantidad != null & cantidad != undefined & idproducto != null & idproducto != undefined) {
            buyOrder.push({idproduct: idproducto, qty: cantidad})
        }

    });

    if (buyOrder.length > 0) {
        var string = JSON.stringify(buyOrder);
        localStorage.setItem('buyOrder', string);
        document.location = "?module=store&buy";
    }

}

var calcTotalCar = function () {
    var total = 0;
    $(".trCarProduct").each(function () {
        var cantidad = $(this).find(".productCant").val();
        var precio = $(this).find(".productPrice").html();
        console.log(cantidad);
        console.log(precio);
        cantidad = parseInt(cantidad);
        precio = parseFloat(precio);

        total += cantidad * precio;
    });
    $(".totalCar").html(total);
}

var getLayoutCar = function () {
    $.ajax({
        url: "index.php?",
        type: "POST",
        dataType: "JSON",
        data: {
            module: "store",
            action: "printLayoutCar",
            products: productsCarList
        },
        success: function (data, status) {
            $("#layout_module").html(data.html);
        }
    });
}

var getAllProductsCar = function () {

};

var addtoCar = function (selector) {
    var idproduct = $(selector).data("idproduct");
    productsCarList.push(idproduct);
    saveProductsCarList();
    setNumberProducts();
    setbtnQuitarProducto(selector);
}

var removeFromCar = function (selector) {
    var idproduct = $(selector).data("idproduct");

    var index = productsCarList.indexOf(idproduct);
    if (index > -1) {
        productsCarList.splice(index, 1);
    }
    saveProductsCarList();
    setNumberProducts();
    setbtnAgregarProducto(selector);
}

var loadCar = function () {
    getProductsCarList();
    setNumberProducts();
    setProductAdded();
}

var setProductAdded = function () {
    $(".addtoCar").each(function () {
        var idproduct = $(this).data("idproduct");
        var exist = productsCarList.indexOf(idproduct);
        if (exist != -1) {
            setbtnQuitarProducto(this);
        }
    });
}

var setbtnAgregarProducto = function (selector) {
    $(selector).html("Agregar Producto");
    $(selector).removeClass("removeFromCar red");
    $(selector).addClass("addtoCar");
}

var setbtnQuitarProducto = function (selector) {
    $(selector).html("Quitar Producto");
    $(selector).removeClass("addtoCar");
    $(selector).addClass("removeFromCar red");
}

var setNumberProducts = function () {
    $(".productsAdded").html(productsCarList.length);
}

var getProductsCarList = function () {
    var data = localStorage.getItem('productsCarList');
    if (data != null) {
        productsCarList = JSON.parse(data);
    }
}

var saveProductsCarList = function () {
    var string = JSON.stringify(productsCarList);
    localStorage.setItem('productsCarList', string);
}