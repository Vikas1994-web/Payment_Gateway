<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body>

    <h1 class="my-5 text-center">Dynamic Razorpay Payment Gateway</h1>

    <div class="container">
        <div class="row justify-content-center">

            <!-- Product 1 -->
            <div class="col-md-4">
                <div class="card text-center mb-4">
                    <div class="card-header">
                        <h2>Silver Plan</h2>
                    </div>
                    <div class="card-body">
                        <h3>1000/- Monthly</h3>
                        <hr>Feature 1
                        <hr>Feature 2
                        <hr>Feature 3
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success pay-btn" data-plan="silver" data-amount="1000">Pay Now</button>
                    </div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="col-md-4">
                <div class="card text-center mb-4">
                    <div class="card-header">
                        <h2>Gold Plan</h2>
                    </div>
                    <div class="card-body">
                        <h3>2000/- Monthly</h3>
                        <hr>Feature A
                        <hr>Feature B
                        <hr>Feature C
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary pay-btn" data-plan="gold" data-amount="2000">Pay Now</button>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="col-md-4">
                <div class="card text-center mb-4">
                    <div class="card-header">
                        <h2>Platinum Plan</h2>
                    </div>
                    <div class="card-body">
                        <h3>3000/- Monthly</h3>
                        <hr>Feature X
                        <hr>Feature Y
                        <hr>Feature Z
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-warning pay-btn" data-plan="platinum" data-amount="3000">Pay Now</button>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
     $(document).ready(function () {
        $(".pay-btn").click(function(){

            var plan = $(this).data("plan");

            //console.log("Button clicked. Plan:", plan, "Amount:", amount);

            $.ajax({
                type: "POST",
                url: "order.php",
                data: {
                    plan: plan,
                },
                success: function (response) {
                    //console.log(response);
                    //console.log(JSON.parse(response))
                   var order_id = JSON.parse(response).order_id;
                   var order_amount = JSON.parse(response).order_amount;
                   var order_plan = JSON.parse(response).order_plan;

                   startPayment(order_id, order_amount, order_plan)
                    
                }
            });
        });
     });


     function startPayment(order_id, order_amount, order_plan) {
           var options = {
                key: "YOUR_API_KEY", // Enter the Key ID generated from the Dashboard
                amount: order_amount, // Amount is in currency subunits. 
                currency: "INR",
                name: "Interbiz",
                description: "Dynamic Plan",
                image: "https://cdn.razorpay.com/logos/GhRQcyean79PqE_medium.png",
                order_id: order_id, // This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                prefill: {
                    name: "XXXXXXX",
                    email: "XXXXXXX",
                    contact: "XXXXXXXX"
                },
                theme: {
                    "color": "#3399cc"
                },
                "handler": function(response) {
                    //alert(response.razorpay_payment_id);
                    window.location.href = "https://www.stpcomputereducation.com";
                }
            };
            var rzp = new Razorpay(options);
            rzp.open();

            rzp.on('payment.failed', function (response){

                alert(response.error.reason);
                // alert(response.error.metadata.order_id);
                // alert(response.error.metadata.payment_id);
            })
     }

    </script>

</body>

</html>