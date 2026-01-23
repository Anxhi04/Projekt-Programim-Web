
<?php
require_once __DIR__ . '/stripe_inicialization.php';
//GJITHE KJO PJESA ESHTE DEMO DHE SUPOZOHET QE SERVICE ID TE VIJE NGA KLIKIMI I NJE BUTONI KUR I BEN BOOK
// KETU ESHTE BERE MANUALISHT NJE SHEMBULL SI DO DUKEJ
$service_id = $_GET['service_id'] ?? 1;

// --------------------------
// Merr çmimin nga DB
require_once __DIR__ . '/../../db.php';
$price = 0;
$q = mysqli_query($connection, "SELECT price, name FROM services WHERE id = '{$service_id}' LIMIT 1");
if(mysqli_num_rows($q)){
    $service = mysqli_fetch_assoc($q);
    $price = (float)$service['price'];
    $service_name = $service['name'];
}else{
    $service_name = "Unknown Service";
}

//DUHET ZEVENDESUAR DERI KETU ME SERVICE ID DINAMIK
$reservationFee = round($price * 0.05, 2); // 5%
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stripe Payment</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <style>
        :root {
            --pink1: rgba(255, 51, 153, 0.68);
            --pink2: rgba(255, 51, 153, 0.85);
            --text: #1f1f1f;
            --light: #ffffff;
            --border: rgba(0,0,0,0.08);
        }

        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; background: #f7f7f7; color: var(--text); }
        .page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { width: 420px; background: var(--light); border-radius: 18px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
        .card-header { background: linear-gradient(135deg, var(--pink1), var(--pink2)); padding: 22px 20px; color: white; }
        .card-header h2 { margin: 0; font-size: 20px; font-weight: 700; }
        .card-header p { margin: 6px 0 0; font-size: 14px; opacity: 0.9; }
        .card-body { padding: 22px 20px; }
        .input-group { margin-bottom: 16px; }
        .input-group label { display: block; font-size: 13px; margin-bottom: 6px; color: rgba(0,0,0,0.7); }
        input[type="text"] { width: 100%; padding: 12px 14px; border: 1px solid var(--border); border-radius: 12px; font-size: 14px; outline: none; transition: border-color 0.2s ease; }
        input[type="text"]:focus { border-color: var(--pink2); box-shadow: 0 0 0 3px rgba(255, 51, 153, 0.15); }
        #card-element { height: 44px; padding: 12px 14px; border: 1px solid var(--border); border-radius: 12px; background: #fff; transition: border-color 0.2s ease; }
        #card-element.StripeElement--focus { border-color: var(--pink2); box-shadow: 0 0 0 3px rgba(255, 51, 153, 0.15); }
        #card-element.StripeElement--invalid { border-color: #ff4d4f; }
        .btn { width: 100%; padding: 12px 14px; border: none; border-radius: 12px; background: linear-gradient(135deg, var(--pink1), var(--pink2)); color: white; font-size: 15px; font-weight: 700; cursor: pointer; transition: transform 0.15s ease, filter 0.15s ease; }
        .btn:hover { filter: brightness(1.05); transform: translateY(-1px); }
        .btn:active { transform: translateY(0px); }
        #error { margin-top: 12px; color: #ff4d4f; font-size: 13px; }
        .footer { padding: 14px 20px; font-size: 12px; color: rgba(0,0,0,0.6); background: #fafafa; border-top: 1px solid var(--border); }
    </style>
</head>
<body>

<div class="page">
    <div class="card">
        <div class="card-header">
            <h2>Pay Reservation Fee</h2>
            <p>Service: <?= htmlspecialchars($service_name) ?></p>
        </div>

        <div class="card-body">
            <div class="input-group">
                <label for="cardholder_name">Cardholder Name</label>
                <input type="text" id="cardholder_name" placeholder="Card Name">
            </div>

            <div class="input-group">
                <label>Card Details</label>
                <div id="card-element"></div>
            </div>


            <div class="input-group" id="reservation-fee-row">
                <label>Reservation Fee (5%)</label>
                <div id="reservation-fee-amount" style="font-weight:bold;">€<?= number_format($reservationFee,2) ?></div>
            </div>

            <button id="payBtn" class="btn">Pay €<?= number_format($reservationFee,2) ?></button>
            <div id="error"></div>
        </div>

        <div class="footer">
            Your payment is secure and encrypted. You can cancel anytime.
        </div>
    </div>
</div>

<script>
    const stripe = Stripe("<?= $public_key ?>");
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    let reservationFee = parseFloat("<?= $reservationFee ?>");


    document.getElementById('payBtn').onclick = async () => {
        document.getElementById('error').innerText = '';

        const name = document.getElementById('cardholder_name').value;
        if(!name){
            document.getElementById('error').innerText = 'Cardholder name is required';
            return;
        }

        const amountInCents = Math.round(reservationFee * 100);


        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: 'card',
            card: card,
            billing_details: { name }
        });

        if(error){
            document.getElementById('error').innerText = error.message;
            return;
        }


        const formData = new FormData();
        formData.append('action', 'create_customer_and_pay');
        formData.append('payment_method', paymentMethod.id);
        formData.append('cardholder_name', name);
        formData.append('service_id', <?= $service_id ?>);
        formData.append('amount', amountInCents);

        let result;
        try{
            const response = await fetch('ajax_payment.php', {
                method:'POST',
                body: formData
            });
            result = await response.json();
        }catch(err){
            document.getElementById('error').innerText = 'Server error';
            return;
        }

        if(result.status !== 200){
            document.getElementById('error').innerText = result.message;
            return;
        }

        // Confirm payment
        const confirm = await stripe.confirmCardPayment(result.client_secret);
        if(confirm.error){
            document.getElementById('error').innerText = confirm.error.message;
            return;
        }

        if(confirm.paymentIntent.status === 'succeeded'){
            const saveData = new FormData();
            saveData.append('action','save_payment');
            saveData.append('payment_intent_id', confirm.paymentIntent.id);
            saveData.append('amount', reservationFee);
            saveData.append('currency','EUR');
            saveData.append('service_id', <?= $service_id ?>);

            await fetch('ajax_payment.php',{
                method:'POST',
                body: saveData
            });

            Swal.fire({
                icon:'success',
                title:'Payment Completed!',
                text:`You paid €${reservationFee} for reservation fee.`,
                confirmButtonText:'Ok',
                confirmButtonColor: "rgba(67,236,41,0.53)"
            });
        }
    };
</script>

</body>
</html>
