-- Project: TUP Connect
-- Created On: Nov. 11, 2021

CREATE DATABASE db_tupconnect
    CHARACTER SET utf8
    COLLATE utf8_general_ci;

USE db_tupconnect;

CREATE TABLE tbl_user(
    `user_id` varchar(15) NOT NULL PRIMARY KEY,
    `user_email` varchar(50) NOT NULL,
    `user_name` varchar(20) NOT NULL,
    `user_password` varchar(20) NOT NULL,
    `user_detail_id` varchar(15) NOT NULL,
    `status` varchar(15) NOT NULL
);

CREATE TABLE tbl_user_verification(
    `user_verification_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_detail_id` varchar(15) NOT NULL,
    `code` varchar(6) NOT NULL,
    `status` varchar(15) NOT NULL
);

CREATE TABLE tbl_user_detail(
    `user_detail_id` varchar(15) NOT NULL PRIMARY KEY,
    `first_name` varchar(30) NOT NULL,
    `middle_name` varchar(30),
    `last_name` varchar(30) NOT NULL,
    `birthday` date NOT NULL,
    `year_level` tinyint NOT NULL,
    `gender_id` int NOT NULL,
    `college_id` int NOT NULL,
    `campus_id` int NOT NULL,
    `course_id` int NOT NULL,
    `user_cor_id` varchar(15) NOT NULL,
    `image_path` varchar(50) NOT NULL
);

CREATE TABLE tbl_user_block(
    `user_block_id` varchar(15) NOT NULL PRIMARY KEY,
    `user_detail_id` varchar(15) NOT NULL,
    `blocked_user_id` varchar(15) NOT NULL,
    `block_id` varchar(15) NOT NULL
);

CREATE TABLE tbl_block(
    `block_id` varchar(15) NOT NULL PRIMARY KEY,
    `block_description` varchar(100) NOT NULL
);

CREATE TABLE tbl_user_interest(
    `user_interest_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_detail_id` varchar(15) NOT NULL,
    `category_id` int NOT NULL
);

CREATE TABLE tbl_user_cor(
    `user_cor_id` varchar(15) NOT NULL PRIMARY KEY,
    `cor_path` varchar(50) NOT NULL,
    `verified` boolean NOT NULL
);

CREATE TABLE tbl_gender(
    `gender_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `gender` varchar(50) NOT NULL
);

CREATE TABLE tbl_college(
    `college_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `college_name` varchar(60) NOT NULL,
    `college_code` varchar(10) NOT NULL
);

CREATE TABLE tbl_campus(
    `campus_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `campus_name` varchar(60) NOT NULL,
    `campus_code` varchar(10) NOT NULL
);

CREATE TABLE tbl_campus_organization(
    `co_id` varchar(15) NOT NULL PRIMARY KEY,
    `campus_id` int NOT NULL,
    `organization_id` varchar(15) NOT NULL
);

CREATE TABLE tbl_lobby(
    `lobby_id` varchar(15) NOT NULL PRIMARY KEY,
    `group_id` varchar(15) NOT NULL,
    `user_detail_id` varchar(15) NOT NULL,
    `campus_id` int NOT NULL,
    `college_id` int NOT NULL
);

CREATE TABLE tbl_course(
    `course_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `course_name` varchar(60) NOT NULL,
    `course_code` varchar(10) NOT NULL
);

CREATE TABLE tbl_organization(
    `organization_id` varchar(15) NOT NULL PRIMARY KEY,
    `organization_name` varchar(15) NOT NULL,
    `category_id` int NOT NULL,
    `organization_image` varchar(100) NOT NULL
);

CREATE TABLE tbl_lobby_post(
    `lobby_post_id` varchar(15) NOT NULL PRIMARY KEY,
    `lobby_id` varchar(15) NOT NULL,
    `category_id` int NOT NULL,
    `post_id` varchar(15) NOT NULL
);

CREATE TABLE tbl_organization_post(
    `organization_post_id` varchar(15) NOT NULL PRIMARY KEY,
    `user_detail_id` varchar(15) NOT NULL,
    `organization_id` varchar(15) NOT NULL,
    `post_id` varchar(15) NOT NULL
);

CREATE TABLE tbl_organization_user(
    `ou_id` varchar(15) NOT NULL PRIMARY KEY,
    `organization_id` varchar(15) NOT NULL, 
    `user_detail_id` varchar(15) NOT NULL, 
    `role_id` int NOT NULL,
    `status` varchar(15) NOT NULL
);

CREATE TABLE tbl_category(
    `category_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `category_name` varchar(50) NOT NULL
);

CREATE TABLE tbl_group(
    `group_id` varchar(15) NOT NULL PRIMARY KEY, 
    `group_name` varchar(50) NOT NULL,
    `category_id` int NOT NULL
);

CREATE TABLE tbl_group_user(
    `group_user_id` varchar(15) NOT NULL PRIMARY KEY,
    `user_detail_id` varchar(15) NOT NULL,
    `role_id` varchar(15) NOT NULL,
    `group_id` varchar(15) NOT NULL
);

CREATE TABLE tbl_post_image(
    `post_image_id` varchar(15) NOT NULL PRIMARY KEY,
    `post_id` varchar(15) NOT NULL,
    `post_image_path` varchar(50) NOT NULL
);

CREATE TABLE tbl_comment_image(
    `comment_image_id` varchar(15) NOT NULL PRIMARY KEY,
    `comment_id` varchar(15) NOT NULL,
    `comment_image_path` varchar(50) NOT NULL
);


CREATE TABLE tbl_comment_reply(
    `comment_reply_id` varchar(15) NOT NULL PRIMARY KEY,
    `comment_id` varchar(15) NOT NULL,
    `reply_id` varchar(15) NOT NULL
);

CREATE TABLE tbl_role(
    `role_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `role_name` varchar(50) NOT NULL
);

CREATE TABLE tbl_freedom_wall(
    `fw_id` varchar(15) NOT NULL PRIMARY KEY,
    `user_detail_id` varchar(15) NOT NULL,
    `post_id` varchar(15) NOT NULL
);

CREATE TABLE tbl_post(
    `post_id` varchar(15) NOT NULL PRIMARY KEY,
    `post_text` text NOT NULL,
    `post_up_vote` int(3) NOT NULL,
    `post_down_vote` int(3) NOT NULL,
    `date_time_stamp` datetime NOT NULL,
    `status` varchar(15) NOT NUll
);

CREATE TABLE tbl_comment(
    `comment_id` varchar(15) NOT NULL PRIMARY KEY,
    `post_id` varchar(15) NOT NULL,
    `comment_text` varchar(2000) NOT NULL,
    `comment_up_vote` int(3) NOT NULL,
    `comment_down_vote` int(3) NOT NULL,
    `user_detail_id` varchar(15) NOT NULL,
    `date_time_stamp` datetime NOT NULL,
    `status` varchar(15) NOT NULL
);

CREATE TABLE tbl_post_report(
    `post_report_id` varchar(15) NOT NULL PRIMARY KEY,
    `post_id` varchar(15) NOT NULL,
    `report_id` varchar(15) NOT NULL
);


CREATE TABLE tbl_comment_report(
    `comment_report_id` varchar(15) NOT NULL PRIMARY KEY,
    `comment_id` varchar(15) NOT NULL,
    `report_id` varchar(15) NOT NULL
);

CREATE TABLE tbl_announcement(
    `announcement_id` varchar(15) NOT NULL PRIMARY KEY,
    `user_detail_id` varchar(15) NOT NULL,
    `campus_id` int NOT NULL,
    `post_id` varchar(15) NOT NULL
);

CREATE TABLE tbl_forum(
    `forum_id` varchar(15) NOT NULL PRIMARY KEY,
    `category_id` int NOT NULL,
    `post_id` varchar(15) NOT NULL,
    `user_detail_id` varchar(15) NOT NULL
);

CREATE TABLE tbl_report(
    `report_id` varchar(15) NOT NULL PRIMARY KEY,
    `report_description` varchar(100) NOT NULL
);

CREATE TABLE tbl_user_report(
    `user_report_id` varchar(15) NOT NULL PRIMARY KEY,
    `user_detail_id` varchar(15) NOT NULL,
    `reported_user_id` varchar(15) NOT NULL,
    `report_id` varchar(15) NOT NUll
);

INSERT INTO tbl_gender(gender) VALUES("Male");
INSERT INTO tbl_gender(gender) VALUES("Female");
INSERT INTO tbl_gender(gender) VALUES("Lesbian");
INSERT INTO tbl_gender(gender) VALUES("Gay");
INSERT INTO tbl_gender(gender) VALUES("Bisexual");
INSERT INTO tbl_gender(gender) VALUES("Transgender");
INSERT INTO tbl_gender(gender) VALUES("Queer");
INSERT INTO tbl_gender(gender) VALUES("Questioning");
INSERT INTO tbl_gender(gender) VALUES("Intersex");
INSERT INTO tbl_gender(gender) VALUES("Asexual");
INSERT INTO tbl_gender(gender) VALUES("Ally");
INSERT INTO tbl_gender(gender) VALUES("Pansexual");
INSERT INTO tbl_gender(gender) VALUES("Demisexual");

INSERT INTO tbl_college(college_name,college_code) VALUES("College of Science","COS");
INSERT INTO tbl_college(college_name,college_code) VALUES("College of Fine Arts","CAFA");
INSERT INTO tbl_college(college_name,college_code) VALUES("College of Engineering","COE");
INSERT INTO tbl_college(college_name,college_code) VALUES("College of Industrial Education","CIE");
INSERT INTO tbl_college(college_name,college_code) VALUES("College of Industrial Technology","CIT");
INSERT INTO tbl_college(college_name,college_code) VALUES("College of Liberal Arts","CLA");

INSERT INTO tbl_campus(campus_name,campus_code) VALUES("Technological University of the Philippines - Manila","TUPM");
INSERT INTO tbl_campus(campus_name,campus_code) VALUES("Technological University of the Philippines - Taguig","TUPT");
INSERT INTO tbl_campus(campus_name,campus_code) VALUES("Technological University of the Philippines - Cavite","TUPC");
INSERT INTO tbl_campus(campus_name,campus_code) VALUES("Technological University of the Philippines - Visayas","TUPV");

INSERT INTO tbl_course(course_name,course_code) VALUES("Bachelor of Science in Civil Engineering","BSCE");
INSERT INTO tbl_course(course_name,course_code) VALUES("Bachelor of Science in Electrical Engineering","BSEE");
INSERT INTO tbl_course(course_name,course_code) VALUES("Bachelor of Science in Mechanical Engineering","BSME");
INSERT INTO tbl_course(course_name,course_code) VALUES("Bachelor of Science in Electronics Engineering","BSEE");

INSERT INTO tbl_course(course_name,course_code) VALUES("Bachelor of Applied Science in Laboratory Technology","BASLT");
INSERT INTO tbl_course(course_name,course_code) VALUES("Bachelor of Science in Computer Science","BSCS");
INSERT INTO tbl_course(course_name,course_code) VALUES("Bachelor of Science in Environmental Science","BSES");
INSERT INTO tbl_course(course_name,course_code) VALUES("Bachelor of Science in Information System","BSIS");
INSERT INTO tbl_course(course_name,course_code) VALUES("Bachelor of Science in Information Technology","BSIT");

INSERT INTO tbl_category(category_name) VALUES("Engineering");
INSERT INTO tbl_category(category_name) VALUES("Programming");
INSERT INTO tbl_category(category_name) VALUES("Arts");
INSERT INTO tbl_category(category_name) VALUES("Education");
INSERT INTO tbl_category(category_name) VALUES("Music");
INSERT INTO tbl_category(category_name) VALUES("Film");
INSERT INTO tbl_category(category_name) VALUES("Mathematics");
INSERT INTO tbl_category(category_name) VALUES("Science");
INSERT INTO tbl_category(category_name) VALUES("Memes");
INSERT INTO tbl_category(category_name) VALUES("Physical Sports");
INSERT INTO tbl_category(category_name) VALUES("Games");
INSERT INTO tbl_category(category_name) VALUES("Books");