CREATE DATABASE doingsdone
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE projects (
id INT(11) AUTO_INCREMENT PRIMARY KEY,
user_id INT(11),
name_project CHAR(124)
);

CREATE TABLE users (
id INT(11) AUTO_INCREMENT PRIMARY KEY,
name_user CHAR(64),
email_user CHAR(254),
password_user CHAR(254),
reg_date_user CHAR(64),
contact_user CHAR(254)
);

CREATE TABLE tasks (
id INT(11) AUTO_INCREMENT PRIMARY KEY,
user_id INT(11),
project_id INT(11),
name_task CHAR(124),
create_date_task CHAR(64),
run_date_task CHAR(64),
limit_date_task CHAR(64),
file_task CHAR(254),
status BOOLEAN,
FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (project_id) REFERENCES projects(id)
);




CREATE FULLTEXT INDEX name_task_index ON tasks(name_task);
CREATE INDEX limit_date_and_status_index ON tasks(limit_date_task,status);
CREATE INDEX status_index ON tasks(status);
CREATE INDEX user_and_project_index ON tasks(user_id,project_id);
CREATE UNIQUE INDEX email_user_index ON users(email_user);