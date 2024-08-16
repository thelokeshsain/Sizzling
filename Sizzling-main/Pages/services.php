<!-- services.php -->

<div class="service-item" id="service1">
    <h3>Service 1</h3>
    <p>Description of Service 1.</p>
    <img src="service1.jpg" alt="Service 1">
    <p class="price">Price: ₹1000</p>
    <button onclick="bookService(1)">Book Now</button>
</div>

<div class="service-item" id="service2">
    <h3>Service 2</h3>
    <p>Description of Service 2.</p>
    <img src="service2.jpg" alt="Service 2">
    <p class="price">Price: ₹1500</p>
    <button onclick="bookService(2)">Book Now</button>
</div>

<script>
    function openBookingModal(service) {
            const bookingModal = document.getElementById('bookingModal');
            const selectedServiceIdInput = document.getElementById('selectedServiceId');
            const selectedServiceInput = document.getElementById('selectedService');

            selectedServiceIdInput.value = service.id;
            selectedServiceInput.value = service.name;
            bookingModal.style.display = 'block';
        }

        // Function to close booking modal
        function closeModal() {
            const bookingModal = document.getElementById('bookingModal');
            bookingModal.style.display = 'none';
        }

        // Function to handle form submission (submit booking request via AJAX)
        function submitBooking(event) {
            event.preventDefault(); // Prevent default form submission

            const serviceId = document.getElementById('selectedServiceId').value;
            const date = document.getElementById('bookingDate').value;
            const time = document.getElementById('bookingTime').value;

            const formData = new FormData();
            formData.append('service_id', serviceId);
            formData.append('date', date);
            formData.append('time', time);

            fetch('book.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    alert('Booking successful!');
                    closeModal(); // Close modal on success
                } else {
                    alert('Booking failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Booking failed. Please try again.');
            });
        }
</script>
