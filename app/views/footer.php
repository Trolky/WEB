<?php

namespace components;

class Footer {
    public static function getFooter() {
        ?>
        <footer class="bg-gray text-white py-4">
            <div class="container">
                <div class="row">
                    <!-- Contact Information -->
                    <div class="col-md-4">
                        <h3>Kontakt</h3>
                        <p><strong>Název:</strong> Your Company Name</p>
                        <p><strong>Tel:</strong> +123 456 7890</p>
                        <p><strong>Email:</strong> contact@example.com</p>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-md-4">
                        <h3>Quick Links</h3>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white">Home</a></li>
                            <li><a href="#" class="text-white">About</a></li>
                            <li><a href="#" class="text-white">Services</a></li>
                            <li><a href="#" class="text-white">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Social Media -->
                    <div class="col-md-4">
                        <h3>Follow Us</h3>
                        <div class="d-flex">
                            <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i> Facebook</a>
                            <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i> Twitter</a>
                            <a href="#" class="text-white"><i class="bi bi-linkedin"></i> LinkedIn</a>
                        </div>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <p>&copy; <?php echo date("Y"); ?> Your Company. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
        <?php
    }
}

?>
