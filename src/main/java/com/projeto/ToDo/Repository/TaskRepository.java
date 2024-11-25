package com.projeto.ToDo.Repository;

import com.projeto.ToDo.Model.Task;
import org.springframework.data.jpa.repository.JpaRepository;

public interface TaskRepository extends JpaRepository<Task, Long> {
}