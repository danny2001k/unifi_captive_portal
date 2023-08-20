# WiFi Captive Portal with UniFi Integration & Email Validation

This project provides a captive portal for WiFi authentication. It integrates with a UniFi controller, allowing users to register using an email address (which can be restricted to a specific domain), receive a verification code, and gain internet access upon successful verification.

## Setup

### Prerequisites

1. **PHP Environment**: Ensure you have PHP running, preferably on a local server environment like XAMPP, MAMP, or a similar solution.
2. **Composer**: Ensure Composer is installed, required for dependency management.
3. **SQLite**: Used as a lightweight database. Ensure the PDO extension for SQLite is enabled in your PHP configuration.

### Installation

1. Navigate to your project's root directory using the command line, then create the specific route needed for UniFi:
   ```bash
   mkdir -p guest/s/{site_id}/
   ```
2. Navigate to the path created above:
   ```bash
   cd guest/s/{site_id}/
   ```
3. Pull the project's contents into this folder:
   ```bash
   git pull danny2001k/unifi_captive_portal
   ```
4. Run the following commands to install the required PHP libraries:
   ```bash
   composer require phpmailer/phpmailer
   composer require art-of-wifi/unifi-api-client
   ```

### Configuration

1. **Config File**: All configurations are housed in the `config.php` file, which includes:
   
   - Database settings
   - Email settings (using PHPMailer)
   - UniFi Controller details (username, password, URL, site ID)

   **Important Note**: For security reasons, keep `config.php` outside of the public directory. Adjust file permissions to ensure only the server process (often `www-data` or similar) has read access, preventing unwanted access and modifications.

2. **Database Setup**: SQLite serves as the database. Create necessary tables for storing user details and verification codes.
3. **Terms & Conditions**: Populate the `terms.php` file with your terms and conditions. Users must agree to these before proceeding.

## Usage Flow

1. **Initial Check**: Accessing `index.php` prompts the system to check for essential parameters (`ap` and `id`). If missing, registration is aborted. For example:
   ```
   http://localhost:3000/?ap=e4:38:83:4c:7b:bd&id=dc:a6:32:58:bc:9e&t=1692276415&url=http://www.example.com
   ```
2. **Registration**: In `register.php`, users input an email and will receive a verification code if it matches the specified domain.
3. **Verification & Connecting**: `verify.php` is where users input the verification code from their email. Upon successful verification, the script connects with the UniFi Controller to authorize user access.
4. **Success/Redirection**: After verifying and connecting, `success_page.php` welcomes users. If a URL is in the initial parameters, users are redirected there. Otherwise, a success message appears.

## Additional Notes

- Ensure system security, especially when user emails are public. Store sensitive data and configurations outside publicly accessible directories.
