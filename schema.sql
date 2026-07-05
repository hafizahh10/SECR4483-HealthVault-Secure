-- =====================================================================
-- SECR4483 SECURE PROGRAMMING: ALTERNATIVE ASSESSMENT
-- Secure Database Schema
-- =====================================================================

CREATE DATABASE IF NOT EXISTS medic_vault_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE medic_vault_db;

-- =====================================================================
-- PATIENT RECORDS TABLE
-- =====================================================================

DROP TABLE IF EXISTS patient_records;

CREATE TABLE patient_records (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(255) NOT NULL,

    illness_history TEXT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- STAFF CREDENTIALS TABLE
-- =====================================================================

DROP TABLE IF EXISTS staff_credentials;

CREATE TABLE staff_credentials (

    id INT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(100) NOT NULL UNIQUE,

    auth_key_hash VARCHAR(255) NOT NULL,

    role VARCHAR(50) NOT NULL,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- SAMPLE PATIENT DATA
-- =====================================================================

INSERT INTO patient_records
(name, illness_history)
VALUES

(
'John Doe',
'DIAGNOSIS: Stage-2 Carcinoma. TREATMENT: Chemotherapy cycle 1. STATUS: Critical.'
),

(
'Jane Smith',
'DIAGNOSIS: Stage-2 Carcinoma. TREATMENT: Radiation therapy. STATUS: Stable.'
),

(
'Robert Thorne',
'DIAGNOSIS: Acute Type-2 Diabetes. TREATMENT: Insulin regimen. STATUS: Managed.'
),

(
'Siti Aminah',
'DIAGNOSIS: Acute Type-2 Diabetes. TREATMENT: Metformin regimen. STATUS: Monitored.'
);

-- =====================================================================
-- SECURE STAFF CREDENTIALS
-- =====================================================================
-- Password hashes generated using:
-- password_hash($password, PASSWORD_ARGON2ID)
--
-- Example passwords:
-- dr_faizal     = TestKey123!
-- dr_sharifah   = DoctorSecret2025!
--
-- Replace with freshly generated hashes during deployment.
-- =====================================================================

INSERT INTO staff_credentials
(username, auth_key_hash, role)
VALUES

(
'dr_faizal',
'$argon2id$v=19$m=65536,t=4,p=1$EXAMPLEHASH001',
'Consultant Physician'
),

(
'dr_sharifah',
'$argon2id$v=19$m=65536,t=4,p=1$EXAMPLEHASH002',
'Chief Medical Officer'
);

-- =====================================================================
-- PRINCIPLE OF LEAST PRIVILEGE
-- =====================================================================
-- Create dedicated application account.
-- Do NOT use root access.
-- =====================================================================

CREATE USER IF NOT EXISTS
'medic_app'@'localhost'
IDENTIFIED BY 'StrongPassword123!';

GRANT SELECT, INSERT, UPDATE
ON medic_vault_db.*
TO 'medic_app'@'localhost';

FLUSH PRIVILEGES;

-- =====================================================================
-- END OF SCRIPT
-- =====================================================================
