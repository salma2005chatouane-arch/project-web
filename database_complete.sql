create database if not exists gestionn_formations;
use gestionn_formations;

create table if not exists users (
    id int auto_increment primary key,
    username varchar(100) not null unique,
    password varchar(255) not null,
    nom varchar(255) not null,
    role enum('admin', 'rh', 'formateur', 'employe') default 'employe',
    created_at timestamp default current_timestamp
);

create table if not exists formations (
    id int auto_increment primary key,
    nom varchar(255) not null,
    duree int not null,
    description text
);

create table if not exists formateurs (
    id int auto_increment primary key,
    nom varchar(255) not null,
    email varchar(255) not null,
    specialite varchar(255)
);

create table if not exists sessions (
    id int auto_increment primary key,
    formation_id int,
    formateur_id int,
    date_debut date,
    date_fin date,
    foreign key (formation_id) references formations(id),
    foreign key (formateur_id) references formateurs(id)
);

create table if not exists inscriptions (
    id int auto_increment primary key,
    session_id int,
    nom_employe varchar(255) not null,
    prenom_employe varchar(255) not null,
    email_employe varchar(255) not null,
    service varchar(100),
    statut varchar(20) default 'confirmee',
    foreign key (session_id) references sessions(id)
);

insert into users (username, password, nom, role) values
('admin', '1234', 'Admin', 'admin'),
('rh', '1234', 'RH', 'rh'),
('formateur', '1234', 'Formateur', 'formateur'),
('employe', '1234', 'Employé', 'employe');

insert into formateurs (nom, email, specialite) values
('hassan kamil', 'hassan.kamil@entreprise.SI', 'React et frameworks JS'),
('douaa amine', 'douaa.09@entreprise.SI', 'Design UI/UX'),
('ahmed sajid', 'sajid.ahmed@entreprise.SI', 'PHP et bases de données'),
('sanna mohamed', 'sanaa.mohamed@entreprise.SI', 'Sécurité informatique'),
('mohammed amine abir', 'medamineabir@entreprise.SI', 'SQL et Architecture'),
('anass ferhan', 'anassferhan@entreprise.SI', 'JavaScript et frontend');

insert into formations (nom, duree, description) values
('Développement Web Avancé', 35, 'Apprendre HTML, CSS, JavaScript et PHP'),
('Management d équipe', 14, 'Techniques de leadership et gestion de conflits'),
('Sécurité Informatique', 7, 'Bonnes pratiques pour sécuriser les données'),
('Excel Avancé', 7, 'Tableaux croisés dynamiques et macros'),
('Communication Professionnelle', 14, 'Améliorer ses présentations et emails');
