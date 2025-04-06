USE php_test;
SET collation_connection = utf8mb4_unicode_ci;
SET NAMES utf8;

INSERT INTO `companies` (`id`,`name`) VALUES
(1,'A@A');

INSERT INTO `agencies` (`id`,`name`) VALUES
(1,'ООО "Рога и копыта"'),
(2,'ООО "Наследие"');

INSERT INTO `countries` (`id`,`name`) VALUES
(1,'Россия'),
(2,'Беларусь'),
(3,'Казахстан');

INSERT INTO `cities` (`id`,`name`,`country_id`) VALUES
(1,'Москва',1),
(2,'Санкт Петербург',1);

INSERT INTO `hotels` (`id`,`name`, `city_id`, `stars`) VALUES
(1,'Балчуг Кемпински Москва', 1, 5),
(2,'Измайлово Альфа', 1, 4),
(3,'Золотое кольцо', 1, 5),
(4,'Плаза Гарден Москва Центр Международной Торговли', 1, 5),
(5,'Измайлово Гамма', 1, 3),
(6,'Нептун', 2, 4),
(7,'Ладога-отель', 2, 3),
(8,'Питер Академия', 2, 3),
(9,'Марко Поло', 2, 4),
(10,'Герцен-Хаус', 2, 1);

INSERT INTO `hotel_agreements` (`id`,`hotel_id`,`discount_percent`,`comission_percent`,`is_default`,`vat_percent`,`vat1_percent`,`vat1_value`,`company_id`,`date_from`,`date_to`,`is_cash_payment`) VALUES
(1,1,10,0,1,20,1,0,1,'2023-01-01','2024-01-01',0),
(2,2,12,0,1,20,1,0,1,'2023-01-01','2024-01-01',0),
(3,3,0,15,1,20,1,0,1,'2023-01-01','2024-01-01',1),
(4,4,12,0,1,20,1,0,1,'2023-01-01','2024-01-01',1),
(5,5,0,10,1,20,1,0,1,'2023-01-01','2024-01-01',1),
(6,6,5,0,1,20,1,0,1,'2023-01-01','2024-01-01',0),
(7,7,0,12,1,20,1,0,1,'2023-01-01','2024-01-01',1),
(8,8,10,0,1,20,1,0,1,'2023-01-01','2024-01-01',1),
(9,9,0,12,1,20,1,0,1,'2023-01-01','2024-01-01',1),
(10,10,14,0,1,20,1,0,1,'2023-01-01','2024-01-01',0);

INSERT INTO `agency_hotel_options` (`id`,`hotel_id`,`agency_id`,`percent`,`is_black`,`is_recomend`,`is_white`) VALUES
(1,1,1,10,0,0,0),
(2,2,1,5,0,0,0),
(3,3,1,8,1,0,0),
(4,4,1,12,0,0,0),
(5,5,1,8,1,0,0),
(6,6,1,15,0,0,0),
(7,7,1,8,0,0,0),
(8,8,1,11,1,0,0),
(9,9,1,12,0,0,0),
(10,10,1,6,0,0,0),
(11,1,2,8,0,0,0),
(12,2,2,12,1,0,0),
(13,3,2,6,0,0,0),
(14,4,2,10,0,0,0),
(15,5,2,9,0,0,0),
(16,6,2,11,1,0,0),
(17,7,2,4,0,0,0),
(18,8,2,12,0,0,0),
(19,9,2,10,1,0,0),
(20,10,2,14,1,0,0);

INSERT INTO php_test.operators (id, `key`, name) VALUES
(1, 'equal', 'равно'),
(2, 'not_equal', 'не равно'),
(3, 'less', 'меньше'),
(4, 'over', 'больше');

INSERT INTO conditions_templates (name, table_name, column_name) VALUES
('Страна отеля', 'countries', 'id'),
('Город отеля', 'cities', 'id'),
('Звездность отеля', 'hotels', 'stars'),
('Комиссия в договоре', 'hotel_agreements', 'discount_percent'),
('Скидка в договоре', 'hotel_agreements', 'comission_percent'),
('Договор по умолчанию', 'hotel_agreements', 'is_default'),
('Компания в договоре с отелем', 'hotel_agreements', 'company_id'),
('Черный список', 'agency_hotel_options', 'is_black'),
('Рекомендованный отель', 'agency_hotel_options', 'is_recomend'),
('Белый список', 'agency_hotel_options', 'is_white');

INSERT INTO available_operators (condition_id, operator_id)
VALUES
((SELECT id FROM conditions_templates WHERE name = 'Страна отеля'), 1),
((SELECT id FROM conditions_templates WHERE name = 'Страна отеля'), 2),

((SELECT id FROM conditions_templates WHERE name = 'Город отеля'), 1),
((SELECT id FROM conditions_templates WHERE name = 'Город отеля'), 2),

((SELECT id FROM conditions_templates WHERE name = 'Звездность отеля'), 1),
((SELECT id FROM conditions_templates WHERE name = 'Звездность отеля'), 2),

((SELECT id FROM conditions_templates WHERE name = 'Комиссия в договоре'), 1),
((SELECT id FROM conditions_templates WHERE name = 'Комиссия в договоре'), 2),
((SELECT id FROM conditions_templates WHERE name = 'Комиссия в договоре'), 3),
((SELECT id FROM conditions_templates WHERE name = 'Комиссия в договоре'), 4),

((SELECT id FROM conditions_templates WHERE name = 'Скидка в договоре'), 1),
((SELECT id FROM conditions_templates WHERE name = 'Скидка в договоре'), 2),
((SELECT id FROM conditions_templates WHERE name = 'Скидка в договоре'), 3),
((SELECT id FROM conditions_templates WHERE name = 'Скидка в договоре'), 4),

((SELECT id FROM conditions_templates WHERE name = 'Договор по умолчанию'), 1),

((SELECT id FROM conditions_templates WHERE name = 'Компания в договоре с отелем'), 1),
((SELECT id FROM conditions_templates WHERE name = 'Компания в договоре с отелем'), 2),

((SELECT id FROM conditions_templates WHERE name = 'Черный список'), 1),

((SELECT id FROM conditions_templates WHERE name = 'Рекомендованный отель'), 1),

((SELECT id FROM conditions_templates WHERE name = 'Белый список'), 1);


INSERT INTO rules (name, agency_id, text_for_manager)
VALUES
    ('Отель должен быть в России', 1, 'Проверить, что отель находится в России и в Санкт-Петербурге'),
    ('Отель не должен быть в черном списке', 2, 'Проверить, что отель не в черном списке'),
    ('Отель должен быть в Санкт-Петербурге', 1, 'Проверить, что отель расположен в Санкт-Петербурге'),
    ('Минимальная звездность отеля 4', 2, 'Проверить, что отель имеет минимум 4 звезды и не находится в черном списке'),
    ('Комиссия в договоре не менее 10%', 1, 'Проверить, что комиссия по договору не ниже 10%');

INSERT INTO conditions (template_id, operator_id, value)
VALUES
    ((SELECT id FROM conditions_templates WHERE name = 'Страна отеля'), (SELECT id FROM operators WHERE `key` = 'equal'), '1'),
    ((SELECT id FROM conditions_templates WHERE name = 'Черный список'), (SELECT id FROM operators WHERE `key` = 'equal'), '0'),
    ((SELECT id FROM conditions_templates WHERE name = 'Город отеля'), (SELECT id FROM operators WHERE `key` = 'equal'), '2'),
    ((SELECT id FROM conditions_templates WHERE name = 'Звездность отеля'), (SELECT id FROM operators WHERE `key` = 'over'), '3'),
    ((SELECT id FROM conditions_templates WHERE name = 'Комиссия в договоре'), (SELECT id FROM operators WHERE `key` = 'over'), '9');

INSERT INTO rules_conditions (rule_id, condition_id)
VALUES
    ((SELECT id FROM rules WHERE name = 'Отель должен быть в России'), (SELECT id FROM conditions WHERE value = '1')),
    ((SELECT id FROM rules WHERE name = 'Отель должен быть в России'), (SELECT id FROM conditions WHERE value = '2')),

    ((SELECT id FROM rules WHERE name = 'Отель не должен быть в черном списке'), (SELECT id FROM conditions WHERE value = '0')),

    ((SELECT id FROM rules WHERE name = 'Отель должен быть в Санкт-Петербурге'), (SELECT id FROM conditions WHERE value = '2')),

    ((SELECT id FROM rules WHERE name = 'Минимальная звездность отеля 4'), (SELECT id FROM conditions WHERE value = '3')),
    ((SELECT id FROM rules WHERE name = 'Минимальная звездность отеля 4'), (SELECT id FROM conditions WHERE value = '0')),

    ((SELECT id FROM rules WHERE name = 'Комиссия в договоре не менее 10%'), (SELECT id FROM conditions WHERE value = '9'));
