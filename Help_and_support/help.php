<?php
    include("../../Files/conn.php");
    include("../../Files/backerConditionalLogout.php");

    $userId = $_SESSION['Backer_userId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help and Support</title>
    <link rel="stylesheet" href="./help.css">
    <link rel="stylesheet" href="../../Files/header_and_footer.css">
    <script src="../../Files/header_and_footer.js" defer></script>
</head>

<body>
    <header style="background-color: #FFD700; color: #005246;">
        <img src="../../Icons/logo.png" alt="logo" class="logo">
        <p class="name">Startup Funding Platform</p>
        <img src="<?php echo $_SESSION['Backer_profileImage']; ?>" alt="profile" class="profile" onclick="toggleMenu()">
        <div class="dropdown-content" id="submenu">
            <div class="dropdown" style="background-image: linear-gradient(to bottom, #ffd700, #f1cd2e, #e4c342, #d6b951, #c8af5e, #b1a55d, #9c9b5c, #89905c, #698154, #4a724e, #2a624a, #005246);">
                <div class="user-info">
                    <img src="<?php echo $_SESSION['Backer_profileImage']; ?>" alt="profile">
                    <h3 id="userName"> <?php echo $_SESSION['Backer_username']; ?> </h3>
                </div>

                <hr>

                <a href="uploadProfileImage.php" class="dropdown-link">
                    <img src="../../Icons/profile_icon.png" alt="icon">
                    <p> Edit Profile </p>
                    <span>></span>
                </a>
                <a href="../../Home/login.php" class="dropdown-link">
                    <img src="../../Icons/setting_icon.png" alt="icon">
                    <p> Settings & Privacy </p>
                    <span>></span>
                </a>
                <a href="../Help_and_support/help.php" class="dropdown-link">
                    <img src="../../Icons/help_icon.png" alt="icon">
                    <p> Help & Support </p>
                    <span>></span>
                </a>
                <a href="../../Home/logout.php" class="dropdown-link">
                    <img src="../../Icons/logout_icon.jpg" alt="icon">
                    <p>Logout</p>
                    <span>></span>
                </a>
            </div>
        </div>
        <div class="navLinks">
            <a href="../Dashboard/dashboard.php" class="links" style="color: #005246;">Dashboard</a>
            <a href="../Discover/discover.php" class="links" style="color: #005246;">Discover</a>
            <a href="../Portifolio/portfoliopage.php" class="links" style="color: #005246;">Portfolio</a>  
            <a href="../Help_and_support/help.php" class="links" style="color: #005246;">Help and Support</a>
        </div>
    </header>

    <div class="container">
        <div class="sidebar">
            <button class="tabButton active"> Help and Support </button>
            <button class="tabButton"> FAQs </button>
            
            <button class="tabButton"> Troubleshooting </button>
            
            <button class="tabButton"> Contact Us </button>
            <button class="tabButton"> Feedback </button>
        </div>

        <div class="contentBox">
            <div class="content active">
                <section>
                    <h2>General Information</h2>
                    <p>Welcome to the Help and Support page for entrepreneurs. Here you can find information on how to use our platform, manage your projects, connect with advisors, and engage with backers.</p>
                </section>

                <section>
                    <h2>Getting Started</h2>
                    <ul>
                        <li><strong>Creating an Account:</strong> Sign up by clicking the 'Sign Up' button on the home page. Fill in your details and verify your email to get started.</li>
                        <li><strong>Setting Up Your Profile:</strong> Complete your profile by adding your business information, goals, and a profile picture to attract backers and advisors.</li>
                    </ul>
                </section>

                <section>
                    <h2>Managing Projects</h2>
                    <ul>
                        <li><strong>Creating a New Project:</strong> Go to the 'Project Management' section and click 'Create New Project'. Fill in the project details, upload relevant files, and set your funding goals.</li>
                        <li><strong>Updating Your Project:</strong> Regularly update your project status to keep your backers informed and engaged. Post updates about milestones, challenges, and successes.</li>
                    </ul>
                </section>

                <section>
                    <h2>Connecting with Backers</h2>
                    <ul>
                        <li><strong>Finding Backers:</strong> Browse through the 'Backers' section to find potential backers who are interested in your industry. Reach out to them with personalized messages.</li>
                        <li><strong>Engaging Backers:</strong> Keep your backers engaged by providing regular updates, responding to their messages, and addressing their concerns promptly.</li>
                    </ul>
                </section>

                <section>
                    <h2>Requesting Advising</h2>
                    <ul>
                        <li><strong>Finding Advisors:</strong> Go to the 'Request Advising' section to find advisors with expertise in your field. Filter advisors by their qualifications and experience.</li>
                        <li><strong>Booking an Advisor:</strong> Once you find a suitable advisor, click on their profile and book a session. Provide details about what you need help with to make the most of your advising session.</li>
                    </ul>
                </section>

                <section>
                    <h2>Reviews and Feedback</h2>
                    <ul>
                        <li><strong>Submitting Reviews:</strong> After a session with an advisor or a successful project milestone, leave a review to help others in the community.</li>
                        <li><strong>Reading Reviews:</strong> Read reviews from other entrepreneurs to find the best advisors and backers for your needs.</li>
                    </ul>
                </section>

                <section>
                    <h2>Messaging</h2>
                    <ul>
                        <li><strong>Sending Messages:</strong> Use the 'Messaging' section to communicate directly with advisors. Keep your messages clear and professional.</li>
                    </ul>
                </section>

                <section>
                    <h2>Resource Library</h2>
                    <ul>
                        <li><strong>Accessing Resources:</strong> Browse the 'Resource Library' for articles, guides, and tools that can help you manage your projects and grow your business.</li>
                        <li><strong>Contributing to the Library:</strong> Share your knowledge and experiences by contributing articles and resources to the library.</li>
                    </ul>
                </section>
            </div>

            <div class="content">
                <section>
                    <h2>FAQs</h2>
                    <div class="faq">
                        <div class="question">
                            <h3>How can I support a project?</h3>
                            <svg width="15" height="10" viewBox="0 0 42 25"> 
                                <path d="M3 3L21 21L39 3" stroke="black" stroke-width="7" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="faq-item">
                            <p>To support a project, browse through our featured projects or explore categories like Technology, Healthcare, Finance, Education, and more. Click on a project of interest and choose your funding amount. Complete the payment process to back the project.</p>
                        </div>
                    </div>
                    <div class="faq">
                        <div class="question">
                            <h3> What categories do projects fall into? </h3>
                            <svg width="15" height="10" viewBox="0 0 42 25"> 
                                <path d="M3 3L21 21L39 3" stroke="black" stroke-width="7" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="faq-item">
                            <p> Projects on our platform are categorized into sectors such as Technology, Healthcare, Finance, Education, and more. You can explore projects based on these categories and find ones that align with your interests.</p>
                        </div>
                    </div>
                    <div class="faq">
                        <div class="question">
                            <h3>How do I know if a project is trustworthy?</h3>
                            <svg width="15" height="10" viewBox="0 0 42 25"> 
                                <path d="M3 3L21 21L39 3" stroke="black" stroke-width="7" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="faq-item">
                            <p> Each project undergoes a review process before being listed. We also encourage backers to check project updates, reviews, and the background of project creators before making a decision. Trustworthy projects usually have detailed descriptions, realistic goals, and positive reviews.</p>
                        </div>
                    </div>
                </section>
            </div>

            <div class="content">
                <section>
                    <h2> Troubleshooting </h2>
                    <p> If you encounter any issues or errors while using our platform, please refer to the troubleshooting steps below. If the problem persists, feel free to contact our support team.</p>
                    <ul>
                        <li><strong> Issue: Unable to log in </strong>
                            <p> Solution: Double-check your username and password. Ensure that your account is verified. If you've forgotten your password, use the "Forgot Password" link to reset it. </p>
                        </li>
                        <li><strong> Issue: Payment processing error </strong>
                            <p> Solution: Verify that your payment details are correct and that you have sufficient funds. Try using a different payment method. If the issue continues, contact your bank or our support team for assistance. </p>
                        </li>
                    </ul>
                </section>
            </div>

            <div class="content">
                <section>
                    <h2>Contact Us</h2>
                    <p>If you have any questions, concerns, or need assistance, feel free to contact us. Our support team is here to help you.</p>
                    <ul>
                        <li><strong>Email:</strong> support@startupfundingplatform.com</li>
                        <li><strong>Phone:</strong> +1 (123) 456-7890</li>
                        <li><strong>Address:</strong> 123 Startup Lane, Innovation City, Country</li>
                    </ul>
                </section>
            </div>

            <div class="content">
                <h2>Feedback</h2>
                <p>We value your feedback! Please share your thoughts and suggestions to help us improve our platform.</p>
                <form id="feedbackForm">
                    <label for="feedback">Your Feedback:</label>
                    <textarea id="feedback" name="feedback" required></textarea>
                    <button type="submit">Submit</button>
                </form>
                <div id="feedbackMessage"></div>
            </div>

            <div class="content">
                <h2>Edit Profile</h2>
                <form id="profileForm" enctype="multipart/form-data">
                    <label for="profileImage">Upload New Profile Image:</label>
                    <input type="file" id="profileImage" name="profileImage" accept="image/*" required>
                    <button type="submit">Update Profile</button>
                </form>
                <div id="profileUpdateMessage"></div>
            </div>
        </div>
    </div>

    <script>
        const tabButtons = document.querySelectorAll('.tabButton');
        const contents = document.querySelectorAll('.content');
        
        tabButtons.forEach((tabButton, index) => {
            tabButton.addEventListener('click', () => {
                // Remove active class from all tab buttons
                tabButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to the clicked tab button
                tabButton.classList.add('active');
                
                // Hide all content
                contents.forEach(content => content.classList.remove('active'));
                
                // Show the content corresponding to the clicked tab button
                contents[index].classList.add('active');
            });
        });

        // JavaScript to handle the FAQ section
        const faqs = document.querySelectorAll('.faq');

        faqs.forEach((faq) => {
            faq.addEventListener('click', () => {
                faq.classList.toggle('open');
                
                // Change icon
                const icon = faq.querySelector('svg');
                icon.classList.toggle('rotate');
            });
        });

        // JavaScript to handle profile image upload and update
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let xhr = new XMLHttpRequest();

            xhr.open('POST', '../../Files/uploadProfileImage.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('profileUpdateMessage').innerText = xhr.responseText;
                    if (xhr.responseText.includes("uploaded")) {
                        let newImagePath = "../../uploads/" + document.getElementById('profileImage').files[0].name;
                        document.querySelector('.profile').src = newImagePath;
                        document.querySelector('.dropdown .user-info img').src = newImagePath;
                    }
                } else {
                    document.getElementById('profileUpdateMessage').innerText = "Error updating profile image.";
                }
            };
            xhr.send(formData);
        });

        function toggleMenu() {
            document.getElementById('submenu').classList.toggle('active');
        }
    </script>
</body>
</html>
