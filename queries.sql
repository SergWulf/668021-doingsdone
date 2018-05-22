-- Добавление 3 пользователей
INSERT INTO users SET name_user = 'Игнат', email_user = 'ignat.v@gmail.com', password_user = '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', reg_date_user = '2018-05-09 22:11:43', contact_user = '+79212343456';
INSERT INTO users SET name_user = 'Леночка', email_user = 'kitty_93@li.ru', password_user = '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', reg_date_user = '2018-05-11 12:15:21', contact_user = '+78202254822';
INSERT INTO users SET name_user = 'Руслан', email_user = 'warrior07@mail.ru', password_user = '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', reg_date_user = '2018-05-12 16:03:10', contact_user = '+79117175060';

-- Добавление проектов
INSERT INTO projects SET name_project = 'Входящие', user_id = 2 ;
INSERT INTO projects SET name_project = 'Работа', user_id = 1;
INSERT INTO projects SET name_project = 'Учёба', user_id = 2;
INSERT INTO projects SET name_project = 'Домашние дела', user_id = 3;
INSERT INTO projects SET name_project = 'Авто', user_id = 3;

-- Добавление задач пользователей
INSERT INTO tasks SET user_id = 1 , project_id = 2, name_task = 'Собеседование в IT компании', create_date_task = '2018-05-17 18:20:13', run_date_task = NULL, limit_date_task = '2018-05-20 21:13:57', file_task = '', status = FALSE;
INSERT INTO tasks SET user_id = 1 , project_id = 2, name_task = 'Выполнить тестовое задание', create_date_task = '2018-05-14 18:11:11', run_date_task = NULL, limit_date_task = '2018-05-18 22:23:21', file_task = '', status = FALSE;
INSERT INTO tasks SET user_id = 1 , project_id = 2, name_task = 'Сделать задание первого раздела', create_date_task = '2018-05-15 03:20:17', run_date_task = NULL, limit_date_task = '2018-05-19 05:22:17', file_task = '', status = FALSE;
INSERT INTO tasks SET user_id = 2 , project_id = 3, name_task = 'Встреча с другом', create_date_task = '2018-05-13 07:23:28', run_date_task = NULL, limit_date_task = '2018-05-18 10:13:39', file_task = '', status = FALSE;
INSERT INTO tasks SET user_id = 2 , project_id = 1, name_task = 'Купить корм для кота', create_date_task = '2018-05-14 7:39:29', run_date_task = NULL, limit_date_task = '2018-5-21 23:22:19', file_task = '', status = FALSE;
INSERT INTO tasks SET user_id = 3 , project_id = 4, name_task = 'Заказать пиццу', create_date_task = '2018-5-16 01:23:48', run_date_task = NULL, limit_date_task = '2018-05-19 21:17:42', file_task = '', status = FALSE;

/*
 Запросы на отображение данных
*/

-- получить список из всех проектов для одного пользователя;
SELECT name_project FROM projects WHERE user_id = 1;

-- получить список из всех задач для одного проекта;
SELECT name_task FROM tasks WHERE project_id = 2;

-- пометить задачу как выполненную;
UPDATE tasks SET status = TRUE WHERE id = 3;

-- получить все задачи для завтрашнего дня;
SELECT name_task FROM tasks WHERE limit_date_task BETWEEN '2018-05-19 23:59:59' AND '2018-05-21 23:59:59';

-- обновить название задачи по её идентификатору.
UPDATE tasks SET name_task = 'Новая задача'
WHERE id = 1;