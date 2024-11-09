<!DOCTYPE html>
<html lang="ar" dir="rtl" >
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
        <!-- Favicon-->

        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">Takzarti</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/">{{Auth::user()->f_name}}</a></li>
                         </ul>
                </div>
            </div>
        </nav>

       <!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            @forelse ($events as $ev)
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <center>
                        <img class="card-img-top" src="{{$ev->firstTeamClub->image}}" style="width: 100px ; height: 100px" alt="Product image" />
                        <img class="card-img-top" src="{{$ev->secondTeamClub->image}}" style="width: 100px ; height: 100px" alt="Product image" />
                    </center>

                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h6 class="fw-bolder">
                                    {{ $ev->firstTeamClub->name_ar }}
                                    Vs {{ $ev->secondTeamClub->name_ar }}
                                </h6>
                                <!-- Product price-->
                                {{ $ev->staduim->name_ar }}
                                <br>
                                <p class="fw-bolder">
                                    {{ $ev->date }}
                                    <br>
                                    @if ($ev->time < 12)
                                        {{ $ev->time }} صباحا
                                @else
                                {{ $ev->time - 12  }} مساءا
                                @endif

                                </p>

                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                @if ($ev->status == 1)
                                <button class="btn btn-outline-success mt-auto">Book</button>
                                @else
                                <p class="btn btn-outline-danger mt-auto"
                                style="pointer-events: none; opacity: 0.6;
                                cursor: not-allowed;">
                                Booked
                            </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <h1>No event found</h1>
            @endforelse

        </div>
    </div>
</section>
<!-- Include Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<!-- Card input form -->
<form id="payment-form">
    <div id="card-element"></div>
    <button id="submit">Pay</button>
</form>

<script>
    const stripe = Stripe('your-publishable-key'); // Replace with your Stripe publishable key
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    document.getElementById('payment-form').addEventListener('submit', async (event) => {
        event.preventDefault();
        const { token, error } = await stripe.createToken(card);
        if (error) {
            console.error(error.message);
        } else {
            // Send token to backend
            fetch('/api/confirm-booking', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    stripeToken: token.id,
                    payment_status: 1, // Example data
                    amount_paid: 123,
                    booking_id: 8
                })
            });
        }
    });
</script>


        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
