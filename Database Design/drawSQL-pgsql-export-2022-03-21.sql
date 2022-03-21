CREATE TABLE "settings"(
    "id" BIGINT NOT NULL,
    "open_at" TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    "close_at" TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL
);
ALTER TABLE
    "settings" ADD PRIMARY KEY("id");
CREATE TABLE "table_types"(
    "id" BIGINT NOT NULL,
    "type_name" VARCHAR(255) NOT NULL,
    "seats" SMALLINT NOT NULL,
    "isActive" BOOLEAN NOT NULL
);
ALTER TABLE
    "table_types" ADD PRIMARY KEY("id");
CREATE TABLE "tables"(
    "id" BIGINT NOT NULL,
    "number" SMALLINT NOT NULL,
    "table_type_id" BIGINT NOT NULL,
    "isActive" BOOLEAN NOT NULL
);
ALTER TABLE
    "tables" ADD PRIMARY KEY("id");
CREATE INDEX "tables_table_type_id_index" ON
    "tables"("table_type_id");
CREATE TABLE "customers"(
    "id" BIGINT NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "phone" VARCHAR(255) NOT NULL
);
ALTER TABLE
    "customers" ADD PRIMARY KEY("id");
ALTER TABLE
    "customers" ADD CONSTRAINT "customers_phone_unique" UNIQUE("phone");
CREATE TABLE "reservations"(
    "id" BIGINT NOT NULL,
    "table_id" BIGINT NOT NULL,
    "customer_id" BIGINT NOT NULL,
    "date" DATE NOT NULL,
    "from" TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    "to" TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    "total_people" SMALLINT NOT NULL,
    "user_id" BIGINT NOT NULL
);
ALTER TABLE
    "reservations" ADD PRIMARY KEY("id");
CREATE INDEX "reservations_table_id_index" ON
    "reservations"("table_id");
CREATE INDEX "reservations_customer_id_index" ON
    "reservations"("customer_id");
CREATE INDEX "reservations_user_id_index" ON
    "reservations"("user_id");
CREATE TABLE "roles"(
    "id" BIGINT NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "isActive" BOOLEAN NOT NULL
);
ALTER TABLE
    "roles" ADD PRIMARY KEY("id");
CREATE TABLE "users"(
    "id" BIGINT NOT NULL,
    "role_id" BIGINT NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "phone" VARCHAR(255) NOT NULL,
    "isActive" BOOLEAN NOT NULL,
    "employee_number" SMALLINT NOT NULL
);
ALTER TABLE
    "users" ADD PRIMARY KEY("id");
CREATE INDEX "users_role_id_index" ON
    "users"("role_id");
ALTER TABLE
    "users" ADD CONSTRAINT "users_phone_unique" UNIQUE("phone");
ALTER TABLE
    "reservations" ADD CONSTRAINT "reservations_customer_id_foreign" FOREIGN KEY("customer_id") REFERENCES "customers"("id");
ALTER TABLE
    "tables" ADD CONSTRAINT "tables_table_type_id_foreign" FOREIGN KEY("table_type_id") REFERENCES "table_types"("id");
ALTER TABLE
    "reservations" ADD CONSTRAINT "reservations_table_id_foreign" FOREIGN KEY("table_id") REFERENCES "tables"("id");
ALTER TABLE
    "reservations" ADD CONSTRAINT "reservations_user_id_foreign" FOREIGN KEY("user_id") REFERENCES "users"("id");
ALTER TABLE
    "users" ADD CONSTRAINT "users_role_id_foreign" FOREIGN KEY("role_id") REFERENCES "roles"("id");