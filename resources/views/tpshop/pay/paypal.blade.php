<div id="paypal-button"></div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
paypal.Button.render({
  // Configure environment
  env: 'sandbox',
  client: {
    sandbox: 'AUSeLXb5nVADSj91f6IOhGa-y3Fs_vNnDg7jd8bBbKiz3OmeRgoAKi0YXjD_ESK-97LmoBOIXG8U3NZ8',
    production: 'demo_production_client_id'
  },
  // Customize button (optional)
  locale: 'en_US',
  style: {
    size: 'small',
    color: 'gold',
    shape: 'pill',
  },
  // Set up a payment
  payment: function (data, actions) {
    return actions.payment.create({
      transactions: [{
        amount: {
          total: '10',
          currency: 'USD'
        }
      }]
    });
  },
  // Execute the payment
  onAuthorize: function (data, actions) {
    return actions.payment.execute()
      .then(function () {
        // Show a confirmation message to the buyer
        alert('Thanh toán thành công, Đơn hàng sẽ sớm được gửi đến bạn..');
      });
  }
}, '#paypal-button');
</script>