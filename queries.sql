-- Добавление 3 пользователей
INSERT INTO users SET name_user = 'Игнат', email_user = 'ignat.v@gmail.com', password_user = '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', reg_date_user = '9.05.2018', contact_user = '+79212343456';
INSERT INTO users SET name_user = 'Леночка', email_user = 'kitty_93@li.ru', password_user = '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', reg_date_user = '11.05.2018', contact_user = '+78202254822';
INSERT INTO users SET name_user = 'Руслан', email_user = 'warrior07@mail.ru', password_user = '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', reg_date_user = '12.05.2018', contact_user = '+79117175060';

-- Добавление проектов
INSERT INTO projects SET name_project = 'Входящие', user_id = 2 ;
INSERT INTO projects SET name_project = 'Работа', user_id = 1;
INSERT INTO projects SET name_project = 'Учёба', user_id = 2;
INSERT INTO projects SET name_project = 'Домашние дела', user_id = 3;
INSERT INTO projects SET name_project = 'Авто', user_id = 3;

-- Добавление задач пользователей
INSERT INTO tasks SET user_id = 1 , project_id = 2, name_task = 'Собеседование в IT компании', create_date_task = '17.05.2018', run_date_task = '', limit_date_task = '20.05.2018', file_task = '', status = FALSE;
INSERT INTO tasks SET user_id = 1 , project_id = 2, name_task = 'Выполнить тестовое задание', create_date_task = '14.05.2018', run_date_task = '', limit_date_task = '18.05.2018', file_task = '', status = FALSE;
INSERT INTO tasks SET user_id = 1 , project_id = 2, name_task = 'Сделать задание первого раздела', create_date_task = '15.05.2018', run_date_task = '', limit_date_task = '19.05.2018', file_task = '', status = FALSE;
INSERT INTO tasks SET user_id = 2 , project_id = 3, name_task = 'Встреча с другом', create_date_task = '13.05.2018', run_date_task = '', limit_date_task = '18.05.2018', file_task = '', status = FALSE;
INSERT INTO tasks SET user_id = 2 , project_id = 1, name_task = 'Купить корм для кота', create_date_task = '14.05.2018', run_date_task = '', limit_date_task = '21.05.2018', file_task = '', status = FALSE;
INSERT INTO tasks SET user_id = 3 , project_id = 4, name_task = 'Заказать пиццу', create_date_task = '16.05.2018', run_date_task = '', limit_date_task = '19.05.2018', file_task = '', status = FALSE;

/*
 Запросы на отображение данных
*/

-- получить список из всех проектов для одного пользователя;
SELECT name_project FROM projects WHERE user_id IN
  (SELECT id FROM users WHERE name_user = 'Игнат');

-- получить список из всех задач для одного проекта;
SELECT name_task FROM tasks WHERE project_id IN
  (SELECT id FROM projects WHERE name_project = 'Работа');

-- пометить задачу как выполненную;
/*
  Еще нужно дополнительно добавить дату выполнения задачи run_date_task, это реализовывать уже посредством PHP?
 */
UPDATE tasks SET status = TRUE WHERE id = 3;

-- получить все задачи для завтрашнего дня;
/*
  Как определить завтрашний день в MySQL. Или тоже реализовывать посредством PHP?
 */
SELECT name_task FROM tasks WHERE limit_date_task = '19.05.2018';

-- обновить название задачи по её идентификатору.
UPDATE tasks SET name_task = 'Новая задача'
WHERE id = 1;