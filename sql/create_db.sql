SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';


CREATE SCHEMA IF NOT EXISTS `db_webcom` DEFAULT CHARACTER SET utf8 ;
USE `db_webcom` ;

CREATE TABLE tb_categorie(
    id_cat int not null primary key auto_increment,
    title varchar(60)
);

CREATE TABLE tb_users(
    id_user int not null primary key auto_increment,
    name_user varchar(100),
    email varchar(100),
    user_mdp varchar(255),
    default_address varchar(100),
    question varchar(100),
    reponse varchar(100),
    date_insc date
);

CREATE TABLE tb_produit(
    id_prod int not null primary key auto_increment,
    id_cat int,
    title varchar(100),
    descrip varchar(300),
    price int,
    mail_seller varchar(80),
    foreign key (id_cat) references tb_categorie(id_cat)
);

CREATE TABLE tb_medias(
    id_media int not null primary key auto_increment,
    id_prod int,
    title_med varchar(80),
    foreign key (id_prod) references tb_produit(id_prod)
);    

CREATE TABLE tb_commande(
    code_com int not null primary key auto_increment,
    id_prod int,
    id_user int,
    date_com date,
    Foreign Key (id_prod) REFERENCES tb_produit(id_prod),
    Foreign Key (id_user) REFERENCES tb_users(id_user),
);    
create table tb_option (
    id_opt int not null auto_increment primary key,
    id_prod int,
    size_prod varchar(10),
    color varchar(20),
    foreign key (id_prod) references tb_produit(id_prod)
)

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;