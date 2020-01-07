
create table users (
id int auto_increment,
f_name varchar(100),
m_name varchar(100),
l_name varchar(100),
email varchar(100),
email_frequency ENUM('never', 'daily', 'monthly', 'weekly'),
phone text,
dob date,
gender ENUM('male', 'female'),
address1 text,
address2 text,
city varchar(100),
state int,
pin int,
password text,
img_path text,

`creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`modification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
primary key (id)
);