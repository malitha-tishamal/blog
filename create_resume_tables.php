<?php
require_once 'includes/db-conn.php';

// Create resume_experience table
$sql1 = "CREATE TABLE IF NOT EXISTS resume_experience (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(255) NOT NULL,
    organization VARCHAR(255) NOT NULL,
    duration VARCHAR(100) NOT NULL,
    description TEXT,
    achievements TEXT,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Create resume_education table
$sql2 = "CREATE TABLE IF NOT EXISTS resume_education (
    id INT AUTO_INCREMENT PRIMARY KEY,
    degree VARCHAR(255) NOT NULL,
    institution VARCHAR(255) NOT NULL,
    year VARCHAR(100) NOT NULL,
    description TEXT,
    details TEXT,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
    echo "Tables created successfully.\n";
    
    // Migrate Experience
    $stmt = $conn->prepare("INSERT INTO resume_experience (role, organization, duration, description, achievements, display_order) VALUES (?, ?, ?, ?, ?, ?)");
    $role = "Volunteer Software Developer";
    $org = "Irrigation Department – Galle";
    $dur = "Oct 2024 – Present";
    $desc = "Contributing to digital transformation initiatives as a volunteer software developer while enhancing hands-on experience in modern software engineering practices.";
    $achievements = "Designed intuitive UI/UX interfaces for internal systems to improve usability and accessibility.\nDeveloped web and mobile applications using modern technologies including Flutter, Dart, and Firebase.\nContinuously learning and applying best practices in cloud integration, API development, and performance optimization.";
    $order = 1;
    $stmt->bind_param("sssssi", $role, $org, $dur, $desc, $achievements, $order);
    $stmt->execute();

    // Migrate Education
    $stmt_edu = $conn->prepare("INSERT INTO resume_education (degree, institution, year, description, details, display_order) VALUES (?, ?, ?, ?, ?, ?)");
    
    $edu_items = [
        [
            "Higher National Diploma in Information Technology (HNDIT)",
            "Sri Lanka Institute of Advanced Technological Institute - Galle",
            "2024 - 2026",
            "Currently pursuing a Higher National Diploma in Information Technology with a strong focus on both theoretical and practical aspects of modern computing.",
            "Core Areas: Software Engineering, Networking, Database Management, Web Application Development.\nPractical Experience: Building real-world projects including web applications, database-driven systems, and network configurations.\nKey Skills: Java, PHP, MySQL, HTML/CSS, JavaScript, and cloud technologies.\nProfessional Development: Emphasis on teamwork, project management, and industry-standard practices.",
            1
        ],
        [
            "Certificate in Web Development",
            "Southern Information Technology Education Center",
            "2023",
            "Successfully completed a certificate course in Web Development covering both frontend and backend fundamentals.",
            "Frontend Skills: HTML5, CSS3, JavaScript, responsive design, and UI/UX basics.\nBackend Basics: Introduction to PHP and MySQL for building dynamic websites.\nProjects: Developed small-scale websites and interactive forms.\nKey Outcome: Gained the ability to design, develop, and deploy simple web applications.",
            2
        ],
        [
            "Certificate in Java Application Development",
            "Southern Information Technology Education Center",
            "2023",
            "Completed a comprehensive training program in Java application development with an emphasis on Object-Oriented Programming (OOP).",
            "Core Topics: Java syntax, OOP principles, exception handling, file I/O, and collections framework.\nPractical Work: Designed and implemented desktop and console-based applications.\nDatabase Integration: Learned JDBC for connecting Java programs with relational databases.\nKey Outcome: Acquired strong problem-solving skills through hands-on coding assignments and projects.",
            3
        ],
        [
            "Advanced Level - Technology Stream",
            "Matara Central College",
            "2020 - 2021",
            "Successfully completed A/Ls in the Technology stream, gaining strong analytical and technical knowledge.",
            "Subjects: Information & Communication Technology (ICT), Engineering Technology, Science for Technology.\nAchievements: Engaged in practical projects, lab experiments, and ICT-based assignments.\nKey Outcome: Built a strong foundation in logical reasoning, problem-solving, and applied technology concepts.",
            4
        ],
        [
            "Diploma in Information Technology",
            "Esoft Metro Campus",
            "2018 - 2019",
            "Completed a diploma program in IT with exposure to hardware, software, and programming fundamentals.",
            "Core Topics: Computer hardware & maintenance, operating systems, networking basics, MS Office suite.\nProgramming: Introduction to C and Visual Basic for problem-solving and simple application building.\nKey Outcome: Gained foundational IT knowledge to pursue higher-level studies in computing.",
            5
        ],
        [
            "Diploma in English",
            "Esoft Metro Campus",
            "2018 - 2019",
            "Completed a diploma in English focusing on communication, grammar, and professional language usage.",
            "Core Areas: Grammar, vocabulary, reading comprehension, and writing skills.\nPractical Skills: Spoken English, presentations, group discussions, and interview preparation.\nKey Outcome: Improved academic writing and professional communication skills for both academic and workplace settings.",
            6
        ]
    ];

    foreach ($edu_items as $item) {
        $stmt_edu->bind_param("sssssi", $item[0], $item[1], $item[2], $item[3], $item[4], $item[5]);
        $stmt_edu->execute();
    }

    echo "Data migrated successfully.";
} else {
    echo "Error creating tables: " . $conn->error;
}
?>
