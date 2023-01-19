
$("#dataTable").DataTable();

// prevent hitting enter
$(document).ready(function () {
    
    $(window).keydown(function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            return false;
        }
    });

    // printing for voucher
$("#print_btn").on('click', function () {

    // get page content
    var pageContent = $("#printArea").html();

    // merge page content for printing
    var printHtml = `
            <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Invoice Voucher</title>
                    <link href="../css/sb-admin2.min.css" rel="stylesheet">
                    <style>
                        *{
                            font-family:'Courier New', Courier, monospace;
                        }
                        .table {
                            width: 100%;
                            margin-top: 50px;
                            margin-bottom: 20px;
                            border-collapse: collapse;
                        }	

                        .table tr,td,th{
                            border: 1px solid #111;
                            padding: 20px;
                        }
                        #left{
                            margin-right: 200px;
                        }
                        #right{
                            maring-left: 200px;
                        }
                        @media print{
                            #print {
                                display:none;
                            }
                        }

                        #print {
	                        width: 90px;
                            height: 30px;
                            font-size: 18px;
                            background: white;
                            <button class="btn btn-primary" id="print_btn">Print</button>

                            <iframe id="print-iframe" width="0" height="0" hidden></iframe>           border-radius: 4px;
	                        margin-left:28px;
	                        cursor:hand;
                        }
		
		            </style>
                </head>
                <body>
                    ${pageContent}
                </body>
            </html>
        `;

    // get iFrame
    let iFrame = document.querySelector('#print-iframe');
    console.log(iFrame);
    iFrame.contentDocument.body.innerHTML = printHtml;
    iFrame.focus();
    iFrame.contentWindow.print();
});
    // printing for voucher


});

// clone child for row
var cloned = $("#order-table tr:last").clone();
// clone chid for row

// adding product row
$("#add_row").on('click', function () {
    cloned.clone().appendTo('#order-table');
});
// adding product row

// deleting product row
$("#order-table").on('click', '#del_row', function () {
    $(this).closest('tr').remove();

    calculateTotal();
})
// deleting product row


// search customer
$("#customer_select").on('change', function () {
    var cus_id = $(this).val();


    $.ajax({
        type: "post",
        url: "search.php",
        data: { cus_id: cus_id },
        success: function (response) {
            var data = (response == "Not found") ? response : JSON.parse(response);

            if (data != "Not found") {
                $("#customer_id").text(data.id);
                $('#hidden_cus_id').val(data.id);
                $("#name").text(data.name);
                $("#address").text(data.address);
                $("#phone").text(data.phone);
                $("#email").text(data.email);
            }
            else {
                $("#customer_id").text("-------");
                $('#hidden_cus_id').val(data.id);
                $("#name").text("-------");
                $("#address").text("-------");
                $("#phone").text("-------");
                $("#email").text("-------");
            }
        }
    });

})

// search customer

// search product
$('#order-table').on('change', '#product_select', function () {

    // catching action for closest input data
    let ele = $(this).closest("tr");
    let data = $("#product_select option:selected", ele).val();
    $('#qty', ele).val("");

    updateStatus(this);
    calculateTotal();

    $.ajax({
        type: "post",
        url: "search.php",
        data: { pro_id: data },
        success: function (response) {
            var data = (response == "Not found") ? response : JSON.parse(response);
            if (data != "Not found") {
                $("#product_name", ele).text(data.name);
                $("#unit_price", ele).text(data.price);
            }
            else {
                $("#qty", ele).val();
                $("#product_name", ele).text("-------");
                $("#subtotal").text(0);
                $("#unit_price", ele).text(0);
            }
        }
    });

});
// search product

// calculate subtotal && total

// checking qty input
$("#order-table").on("blur", "#qty", function () {

    let ele = $(this).closest("tr");
    let data = $("#qty", ele).val();
    let check = $("#product_name", ele).val();

    let length = $.trim(data).length;
    if (length == 0 && check != "-------") {
        $("#qty", ele).attr("class", "form-control w-25 mx-auto border border-danger");
        $("#err_qty", ele).text("Enter quantity");
    }
});
// checking qty input
$("#order-table").on("input", "#qty", function () {
    ele = $(this).closest("tr");

    // change style
    $("#qty", ele).attr("class", "form-control w-25 mx-auto");
    $("#err_qty", ele).text("");

    // Calculation for subtotal and total
    updateStatus(this);
    calculateTotal();
});

// calculation functions
function updateStatus(element) {
    let ele = $(element).closest("tr");
    let price = $("#unit_price", ele).text();
    let qty = $("#qty", ele).val();

    if (qty != 0 && Math.sign(parseInt(qty)) > 0) {
        let subtotal = parseFloat(price) * parseInt(qty);
        $("#subtotal", ele).text(subtotal.toFixed());
    }
    else {
        $('#qty', ele).val('');
        $("#subtotal", ele).text(0);
    }
}
function calculateTotal() {
    var total = 0;
    $("#order-table tbody tr").each(function () {
        subtotal = parseFloat($("#subtotal", this).text());

        total += subtotal;
    });
    $("#total").text(total.toFixed());
    $("#hidden_total").val(total);
}
// calculation functions
// calculate subtotal && total

