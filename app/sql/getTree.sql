SELECT *
FROM oasu.faculties
         JOIN oasu.department
              ON oasu.faculties.faculty_id = oasu.department.id_of_faculties
         JOIN oasu.group
              ON oasu.department.department_id = oasu.group.id_of_department
         JOIN oasu.students
              ON oasu.group.group_id = oasu.students.id_of_group;