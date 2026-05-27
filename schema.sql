-- MySQL schema (migrations 000001 + 000002 + 000003 applied)

CREATE TABLE users
(
    id         CHAR(36)                     NOT NULL DEFAULT (UUID()),
    role       ENUM ('ADMIN','SUPER_ADMIN') NOT NULL,
    name       VARCHAR(255)                 NOT NULL,
    email      VARCHAR(255)                 NOT NULL,
    password   TEXT                         NOT NULL,
    created_at TIMESTAMP                    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP                    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE faculties
(
    id         CHAR(36)     NOT NULL DEFAULT (UUID()),
    code       VARCHAR(20)  NOT NULL,
    name       VARCHAR(255) NOT NULL,
    dean_name  VARCHAR(255),
    is_active  BOOLEAN      NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE students
(
    id              CHAR(36)     NOT NULL DEFAULT (UUID()),
    faculty_id      CHAR(36)     NOT NULL,
    nim             VARCHAR(20)  NOT NULL,
    full_name       VARCHAR(255) NOT NULL,
    email           VARCHAR(255) NOT NULL,
    password        TEXT         NOT NULL,
    is_eligible     BOOLEAN      NOT NULL DEFAULT TRUE,
    enrollment_year SMALLINT     NOT NULL,
    created_at      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_students_nim (nim),
    UNIQUE KEY uq_students_email (email),
    KEY idx_students_faculty (faculty_id),
    KEY idx_students_eligible (is_eligible),
    CONSTRAINT fk_students_faculty FOREIGN KEY (faculty_id) REFERENCES faculties (id) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE election_periods
(
    id            CHAR(36)                       NOT NULL DEFAULT (UUID()),
    name          VARCHAR(255)                   NOT NULL,
    year          SMALLINT                       NOT NULL,
    theme_config  JSON                           NOT NULL,
    reg_start_at  TIMESTAMP                      NOT NULL,
    reg_end_at    TIMESTAMP                      NOT NULL,
    vote_start_at TIMESTAMP                      NOT NULL,
    vote_end_at   TIMESTAMP                      NOT NULL,
    status        ENUM ('DRAFT','VOTING','DONE') NOT NULL DEFAULT 'DRAFT',
    created_by    CHAR(36)                       NULL,
    created_at    TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP                      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_periods_year (year),
    KEY idx_periods_status (status),
    KEY idx_periods_created_by (created_by),
    CONSTRAINT fk_periods_created_by FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT chk_periods_reg_window CHECK (reg_end_at > reg_start_at),
    CONSTRAINT chk_periods_vote_window CHECK (vote_end_at > vote_start_at),
    CONSTRAINT chk_periods_reg_before_vote CHECK (vote_start_at >= reg_end_at)
) ENGINE = InnoDB;

CREATE TABLE election_schedules
(
    id            CHAR(36)  NOT NULL PRIMARY KEY DEFAULT (UUID()),
    period_id     CHAR(36)  NOT NULL,
    vote_start_at TIMESTAMP NOT NULL,
    vote_end_at   TIMESTAMP NOT NULL,
    created_at    TIMESTAMP NOT NULL,
    updated_at    TIMESTAMP NOT NULL,
    CONSTRAINT chk_periods_vote_window CHECK (vote_end_at > vote_start_at)
) ENGINE = InnoDB;

CREATE TABLE election_categories
(
    id               CHAR(36)                                    NOT NULL DEFAULT (UUID()),
    period_id        CHAR(36)                                    NOT NULL,
    scope_faculty_id CHAR(36)                                    NULL,
    type             ENUM ('PRESIDENT','DPM','FACULTY_GOVERNOR') NOT NULL,
    title            VARCHAR(255)                                NOT NULL,
    description      TEXT,
    vote_start_at    TIMESTAMP                                   NULL,
    vote_end_at      TIMESTAMP                                   NULL,
    max_winners      SMALLINT                                    NOT NULL DEFAULT 1,
    created_at       TIMESTAMP                                   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at       TIMESTAMP                                   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_category_period (period_id),
    KEY idx_category_scope_faculty (scope_faculty_id),
    CONSTRAINT fk_category_period FOREIGN KEY (period_id) REFERENCES election_periods (id) ON DELETE CASCADE,
    CONSTRAINT fk_category_faculty FOREIGN KEY (scope_faculty_id) REFERENCES faculties (id) ON DELETE RESTRICT
) ENGINE = InnoDB;

CREATE TABLE candidates
(
    id          CHAR(36)  NOT NULL DEFAULT (UUID()),
    category_id CHAR(36)  NOT NULL,
    number      SMALLINT  NOT NULL,
    vision      TEXT      NOT NULL,
    mission     TEXT      NOT NULL,
    photo_url   TEXT,
    video_url   TEXT,
    created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_candidates_number_per_category (category_id, number),
    KEY idx_candidates_category (category_id),
    CONSTRAINT fk_candidates_category FOREIGN KEY (category_id) REFERENCES election_categories (id) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE candidate_members
(
    id           CHAR(36)                            NOT NULL DEFAULT (UUID()),
    candidate_id CHAR(36)                            NOT NULL,
    student_id   CHAR(36)                            NOT NULL,
    role         ENUM ('INDIVIDUAL','KETUA','WAKIL') NOT NULL,
    created_at   TIMESTAMP                           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP                           NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_candidate_members_candidate (candidate_id),
    KEY idx_candidate_members_student (student_id),
    CONSTRAINT fk_cm_candidate FOREIGN KEY (candidate_id) REFERENCES candidates (id) ON DELETE CASCADE,
    CONSTRAINT fk_cm_student FOREIGN KEY (student_id) REFERENCES students (id) ON DELETE RESTRICT
) ENGINE = InnoDB;

CREATE TABLE ballots
(
    id          CHAR(36)  NOT NULL DEFAULT (UUID()),
    category_id CHAR(36)  NOT NULL,
    student_id  CHAR(36)  NOT NULL,
    voted_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ip_address  VARCHAR(20),
    user_agent  TEXT,
    PRIMARY KEY (id),
    UNIQUE KEY uq_ballots_one_vote_per_student_per_race (category_id, student_id),
    KEY idx_ballots_race_student (category_id, student_id),
    KEY idx_ballots_voted_at (voted_at),
    CONSTRAINT fk_ballots_category FOREIGN KEY (category_id) REFERENCES election_categories (id) ON DELETE RESTRICT
) ENGINE = InnoDB;

CREATE TABLE vote_tallies
(
    id           CHAR(36)  NOT NULL DEFAULT (UUID()),
    candidate_id CHAR(36)  NOT NULL,
    vote_count   INT       NOT NULL DEFAULT 0,
    last_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_vote_tallies_candidate (candidate_id),
    CONSTRAINT fk_tallies_candidate FOREIGN KEY (candidate_id) REFERENCES candidates (id) ON DELETE CASCADE,
    CONSTRAINT chk_tallies_vote_count CHECK (vote_count >= 0)
) ENGINE = InnoDB;

CREATE TABLE audit_logs
(
    id          CHAR(36)     NOT NULL DEFAULT (UUID()),
    actor_id    CHAR(36)     NULL,
    event_type  VARCHAR(100) NOT NULL,
    entity_type VARCHAR(50),
    entity_id   CHAR(36),
    meta        JSON,
    ip_address  VARCHAR(20)  NOT NULL,
    created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_audit_actor (actor_id),
    KEY idx_audit_event_type (event_type),
    KEY idx_audit_entity (entity_type, entity_id),
    KEY idx_audit_created (created_at DESC),
    CONSTRAINT fk_audit_actor FOREIGN KEY (actor_id) REFERENCES users (id) ON DELETE SET NULL
) ENGINE = InnoDB;
