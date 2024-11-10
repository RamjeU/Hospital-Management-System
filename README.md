# Hospital Management System
https://cs3319.gaul.csd.uwo.ca/vm224/a3tiger/mainmenu.php 

Welcome to **Ramje Hospital Management System** – a dynamic, responsive, and robust web application for managing hospital operations. This project was created with passion and dedication to showcase a professional-grade management tool that integrates multiple functionalities for efficient healthcare administration.

## 🌟 Project Highlights
- **Patient Management**: List, insert, update, and delete patient records with ease.
- **Doctor Insights**: Identify doctors without assigned patients and view a comprehensive list of doctors and their patients.
- **Nurse Reports**: Generate detailed reports for nurses, showcasing their assigned doctors, hours worked, and supervisors.
- **Dynamic UI**: User-friendly and consistent interface powered by PHP, HTML, CSS, and MySQL.
- **Real-Life Utility**: Built to emulate real-world hospital management systems with data-driven insights.

## 💻 Features
1. **Main Menu**: A central hub to access all functionalities.
2. **Patient Management**:
   - View all patients, sorted by first or last name in ascending/descending order.
   - Add new patients with unique OHIP numbers and doctor assignments.
   - Modify patient details, including weight (kg/pounds) and height (meters/feet & inches).
   - Delete patient records with confirmation prompts.
3. **Doctor Management**:
   - Identify doctors without assigned patients.
   - List all doctors with their respective patients.
4. **Nurse Management**:
   - Generate detailed reports for nurses, including hours worked and supervisors.
5. **Database Integration**: Powered by MySQL for seamless data handling.
6. **Responsive Design**: Intuitive and aesthetically pleasing interface.

## 🚀 Setup Instructions
### Prerequisites
- PHP (version 7.4 or above)
- MySQL
- A local or online web server (e.g., XAMPP, WAMP, or LAMP)

### Steps to Run
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/yourusername/HospitalManagementSystem.git
   cd HospitalManagementSystem
   ```
2. **Set Up Database**:
   - Import the `sql/moredatafall2024.sql` file into your MySQL database.
   - Update the database credentials in `php/connectdb.php` to match your local configuration.
3. **Run the Application**:
   - Place the project folder in your web server’s root directory (e.g., `htdocs` for XAMPP).
   - Access the application in your browser at `http://localhost/HospitalManagementSystem/php/mainmenu.php`.

## 📂 Directory Structure
```
HospitalManagementSystem/
├── css/
│   └── style.css
├── sql/
│   └── moredatafall2024.sql
├── php/
│   ├── connectdb.php
│   ├── mainmenu.php
│   ├── list_patients.php
│   ├── insert_patient.php
│   ├── delete_patient.php
│   ├── modify_patient.php
│   ├── doctors_without_patients.php
│   ├── doctor_patient_list.php
│   └── nurse_report.php
└── README.md
```

## 🎨 Design Philosophy
This project follows a consistent and minimalistic design to ensure ease of use and accessibility:
- A clean layout for navigation and interaction.
- Consistent colour themes for a professional aesthetic.
- Hover effects for an intuitive user experience.

## 🙌 Why I Loved Building This
This project challenged me to combine database management, backend development, and UI design into a cohesive system. I thoroughly enjoyed integrating real-world functionalities and designing a system that reflects professional-grade applications. Building this taught me:
- Advanced SQL queries and joins.
- Designing dynamic interfaces with PHP and CSS.
- Managing and structuring projects for scalability.

## 🛠️ Built With
- **PHP**: For dynamic server-side scripting.
- **MySQL**: To handle database operations.
- **HTML5 & CSS3**: For a responsive and user-friendly interface.
- **XAMPP**: To run the application locally.

## 🏅 Future Enhancements
- Add authentication for secure access.
- Implement role-based access control for doctors, nurses, and admin.
- Include advanced analytics dashboards for hospital insights.

## 📜 License
This project is licensed under the MIT License.

---
Built with ❤️ by Ramje Uthayakumaar
