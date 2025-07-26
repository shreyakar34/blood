# HEMO HUB  
**Blood Donation Management System**

## Project Overview

HEMO HUB is a database-driven web application developed to facilitate efficient coordination between blood donors, hospitals, and receivers. It streamlines the processes of donor registration, blood collection, inventory management, and blood unit request fulfillment. The system ensures real-time data updates, secure access, and improved decision-making through analytical reporting.

---

## Tech Stack

**Frontend:**  
- HTML  
- CSS  
- JavaScript  
- Bootstrap

**Backend:**  
- PHP  
- MySQL

---

## System Modules and Features

### Donor Management
- Register donors with personal details including name, contact information, blood type, and city.
- Record and maintain donation history for each donor.

### Hospital Management
- Register hospitals with relevant contact and location information.
- Allow hospitals to request blood based on specific type and quantity.
- Track and manage in-house blood inventory.

### Blood Stock Management
- Maintain a centralized view of blood stock available across hospitals.
- Automatically update stock levels upon donation or request fulfillment.

### Blood Request Fulfillment
- Enable receivers to request specific blood types and quantities.
- Validate availability and fulfill requests from hospitals with matching stock.

### Reporting and Analysis
- Generate reports on donation trends, blood stock levels, and request patterns.
- Support data-driven insights for operational improvements.

### Authentication and Security
- Implement secure login for donors, hospitals, and receivers.
- Ensure role-based access and protection of sensitive user information.

---

## Database Schema Overview

### Tables
- `donors`: Contains donor details.
- `receivers`: Stores receiver information.
- `hospitals`: Manages hospital records.
- `donates`: Logs blood donation entries.
- `bloodstock`: Maintains blood type quantities per hospital.
- `bloodrequest`: Handles blood requests and their statuses.

### Stored Procedures
- `check_stock_and_request_blood`: Validates and processes blood requests based on availability.
- `GetDonorDetailsByHospital`: Retrieves donors associated with a particular hospital.

### Triggers
- `trg_update_bloodstock`: Updates blood stock after a request is accepted.
- `update_stock_quantity`: Updates stock following a successful donation.

### Cursor
- `GetDonationDetailsByDonor`: Extracts the complete donation history for a specific donor.

---

## User Interface Overview

- **Home Page:** Educational content on blood types and health-related information.
- **Blood Compatibility Checker:** Verifies compatibility across different blood groups.
- **Registration and Login:** Available for Donors, Hospitals, and Receivers.
- **Donor Dashboard:** Profile updates, donation history, and blood contribution logging.
- **Hospital Dashboard:** Access to donor list, blood inventory, and request management.
- **Receiver Dashboard:** View available stock and manage blood requests.

---

## Conclusion

The HEMO HUB project provides a comprehensive and reliable solution for managing the end-to-end process of blood donation, inventory tracking, and request handling. Through its user-centric design and robust database architecture, the system ensures timely access to life-saving blood resources. Features such as automated triggers, stored procedures, and secure authentication contribute to a scalable and maintainable application ideal for healthcare institutions and blood banks.


