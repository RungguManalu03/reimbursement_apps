/*
 Navicat Premium Data Transfer

 Source Server         : server_postgre_local
 Source Server Type    : PostgreSQL
 Source Server Version : 140005 (140005)
 Source Host           : localhost:5432
 Source Catalog        : reimbursement
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 140005 (140005)
 File Encoding         : 65001

 Date: 09/05/2024 18:24:18
*/


-- ----------------------------
-- Sequence structure for migrations_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."migrations_id_seq";
CREATE SEQUENCE "public"."migrations_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for personal_access_tokens_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."personal_access_tokens_id_seq";
CREATE SEQUENCE "public"."personal_access_tokens_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS "public"."migrations";
CREATE TABLE "public"."migrations" (
  "id" int4 NOT NULL DEFAULT nextval('migrations_id_seq'::regclass),
  "migration" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "batch" int4 NOT NULL
)
;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO "public"."migrations" VALUES (38, '2014_10_12_000000_create_users_table', 1);
INSERT INTO "public"."migrations" VALUES (39, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO "public"."migrations" VALUES (40, '2024_05_07_103814_create_reimbursements_table', 1);
INSERT INTO "public"."migrations" VALUES (41, '2024_05_07_121646_create_reimbursement_files_table', 1);

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS "public"."personal_access_tokens";
CREATE TABLE "public"."personal_access_tokens" (
  "id" int8 NOT NULL DEFAULT nextval('personal_access_tokens_id_seq'::regclass),
  "tokenable_type" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "tokenable_id" int8 NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "token" varchar(64) COLLATE "pg_catalog"."default" NOT NULL,
  "abilities" text COLLATE "pg_catalog"."default",
  "last_used_at" timestamp(0),
  "expires_at" timestamp(0),
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
)
;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for reimbursement_files
-- ----------------------------
DROP TABLE IF EXISTS "public"."reimbursement_files";
CREATE TABLE "public"."reimbursement_files" (
  "id" uuid NOT NULL,
  "reimbursement_id" uuid NOT NULL,
  "file_name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
)
;

-- ----------------------------
-- Records of reimbursement_files
-- ----------------------------
INSERT INTO "public"."reimbursement_files" VALUES ('ac64a52e-fd9c-47b3-b896-48d20ec0c3e9', '9653fb81-64e7-4f36-92b0-8ad3ab036944', '3.PNG', '2024-05-09 16:16:32', '2024-05-09 16:16:32');
INSERT INTO "public"."reimbursement_files" VALUES ('2f6f46a6-6325-403f-bd55-c3992fbfd1cf', '9653fb81-64e7-4f36-92b0-8ad3ab036944', '2.PNG', '2024-05-09 16:16:32', '2024-05-09 16:16:32');
INSERT INTO "public"."reimbursement_files" VALUES ('7b56fcf7-133a-48ec-9a45-f06fd2892bad', 'f19e44f0-1f05-42b0-8bc8-6300c66086bb', '3.PNG', '2024-05-09 16:17:17', '2024-05-09 16:17:17');
INSERT INTO "public"."reimbursement_files" VALUES ('37b4d6eb-956c-487d-98f4-92ab17860dfd', 'f19e44f0-1f05-42b0-8bc8-6300c66086bb', '2.PNG', '2024-05-09 16:17:17', '2024-05-09 16:17:17');
INSERT INTO "public"."reimbursement_files" VALUES ('1d691e96-a33f-40eb-ae23-eec27e34dad9', 'a1ae18da-23d0-4926-a02e-ef4bf67859ac', '2.PNG', '2024-05-09 16:17:30', '2024-05-09 16:17:30');
INSERT INTO "public"."reimbursement_files" VALUES ('f1319bef-1d62-44c1-97a5-e81318483610', 'a1ae18da-23d0-4926-a02e-ef4bf67859ac', '1.PNG', '2024-05-09 16:17:30', '2024-05-09 16:17:30');
INSERT INTO "public"."reimbursement_files" VALUES ('d9c6483c-ceb9-4d18-9c1c-862dbabb275f', '916530b7-8bb6-41a3-aa48-4695fa54b296', '3.PNG', '2024-05-09 16:17:44', '2024-05-09 16:17:44');
INSERT INTO "public"."reimbursement_files" VALUES ('67888351-a61a-49e6-9e3d-fd5057c03af9', '916530b7-8bb6-41a3-aa48-4695fa54b296', '2.PNG', '2024-05-09 16:17:44', '2024-05-09 16:17:44');

-- ----------------------------
-- Table structure for reimbursements
-- ----------------------------
DROP TABLE IF EXISTS "public"."reimbursements";
CREATE TABLE "public"."reimbursements" (
  "id" uuid NOT NULL,
  "user_id" uuid NOT NULL,
  "nama" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "nominal" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "status" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "tanggal" date NOT NULL,
  "deskripsi" text COLLATE "pg_catalog"."default" NOT NULL,
  "direktur_agreement" varchar(255) COLLATE "pg_catalog"."default",
  "finance_agreement" varchar(255) COLLATE "pg_catalog"."default",
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
)
;

-- ----------------------------
-- Records of reimbursements
-- ----------------------------
INSERT INTO "public"."reimbursements" VALUES ('916530b7-8bb6-41a3-aa48-4695fa54b296', '43c6f1f4-ccdc-4fec-9f52-dfdbd4b0efad', 'DONA', 'Rp 1234.545', 'TOLAK-DIREKTUR', '2024-05-31', 'asasa', 'DONI', NULL, '2024-05-09 16:17:44', '2024-05-09 16:19:17');
INSERT INTO "public"."reimbursements" VALUES ('f19e44f0-1f05-42b0-8bc8-6300c66086bb', '43c6f1f4-ccdc-4fec-9f52-dfdbd4b0efad', 'DONA', 'Rp 1234.545', 'APPROVE', '2024-05-28', 'asasasa', 'DONI', 'DONO', '2024-05-09 16:17:17', '2024-05-09 16:22:15');
INSERT INTO "public"."reimbursements" VALUES ('9653fb81-64e7-4f36-92b0-8ad3ab036944', '43c6f1f4-ccdc-4fec-9f52-dfdbd4b0efad', 'DONA', 'Rp 344.546', 'TOLAK-FINANCE', '2024-05-02', 'asasa', 'DONI', 'DONO', '2024-05-09 16:16:29', '2024-05-09 16:22:41');
INSERT INTO "public"."reimbursements" VALUES ('a1ae18da-23d0-4926-a02e-ef4bf67859ac', '43c6f1f4-ccdc-4fec-9f52-dfdbd4b0efad', 'DONA', 'Rp 1234.545', 'VERIFIKASI-DIREKTUR', '2024-05-15', 'asasa', 'DONI', NULL, '2024-05-09 16:17:30', '2024-05-09 16:22:55');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "public"."users";
CREATE TABLE "public"."users" (
  "id" uuid NOT NULL,
  "nip" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "nama" varchar(255) COLLATE "pg_catalog"."default",
  "jabatan" varchar(255) COLLATE "pg_catalog"."default",
  "password" varchar(255) COLLATE "pg_catalog"."default",
  "created_at" timestamp(0),
  "updated_at" timestamp(0)
)
;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO "public"."users" VALUES ('a09d3f86-52bb-44b2-af6f-71e48d6b2062', '1234', 'DONI', 'DIREKTUR', '$2y$12$hB/lFE6PPG8P8sRUkavKw.cxsuTERG0GoikQ.X6v/PLyQyPl/xCvy', '2024-05-09 09:13:59', '2024-05-09 09:13:59');
INSERT INTO "public"."users" VALUES ('a31c5a55-c7f3-49f6-a41f-0a5f6cee180a', '1235', 'DONO', 'FINANCE', '$2y$12$GLMDCBBlTTcM3pmsZhCX4emTsJBGTGzUXkNDN1vfw9EWAgTaPclsi', '2024-05-09 09:13:59', '2024-05-09 09:13:59');
INSERT INTO "public"."users" VALUES ('43c6f1f4-ccdc-4fec-9f52-dfdbd4b0efad', '1236', 'DONA', 'STAFF', '$2y$12$8b/X/TY7cilpGUG3CE87m.t/8UECvb8Ht9F4cMSvMM6EtukwMZVZe', '2024-05-09 09:13:59', '2024-05-09 09:13:59');
INSERT INTO "public"."users" VALUES ('bea0827d-4c26-4d1f-89fe-cba680a27c95', '1238', 'Runggu Marusaha Manalu 123', 'STAFF', '$2y$12$29.hCJOTQS.RhYcSOK/EJeijcymsFBwLiCh2WBzrgdbulKQkNbgwa', '2024-05-09 17:54:16', '2024-05-09 18:16:03');

-- ----------------------------
-- Function structure for uuid_generate_v1
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v1"();
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v1"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v1'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v1mc
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v1mc"();
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v1mc"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v1mc'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v3
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v3"("namespace" uuid, "name" text);
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v3"("namespace" uuid, "name" text)
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v3'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v4
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v4"();
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v4"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v4'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v5
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v5"("namespace" uuid, "name" text);
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v5"("namespace" uuid, "name" text)
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v5'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_nil
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_nil"();
CREATE OR REPLACE FUNCTION "public"."uuid_nil"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_nil'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_dns
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_dns"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_dns"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_dns'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_oid
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_oid"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_oid"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_oid'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_url
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_url"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_url"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_url'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_x500
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_x500"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_x500"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_x500'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."migrations_id_seq"
OWNED BY "public"."migrations"."id";
SELECT setval('"public"."migrations_id_seq"', 41, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."personal_access_tokens_id_seq"
OWNED BY "public"."personal_access_tokens"."id";
SELECT setval('"public"."personal_access_tokens_id_seq"', 1, false);

-- ----------------------------
-- Primary Key structure for table migrations
-- ----------------------------
ALTER TABLE "public"."migrations" ADD CONSTRAINT "migrations_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table personal_access_tokens
-- ----------------------------
CREATE INDEX "personal_access_tokens_tokenable_type_tokenable_id_index" ON "public"."personal_access_tokens" USING btree (
  "tokenable_type" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "tokenable_id" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Uniques structure for table personal_access_tokens
-- ----------------------------
ALTER TABLE "public"."personal_access_tokens" ADD CONSTRAINT "personal_access_tokens_token_unique" UNIQUE ("token");

-- ----------------------------
-- Primary Key structure for table personal_access_tokens
-- ----------------------------
ALTER TABLE "public"."personal_access_tokens" ADD CONSTRAINT "personal_access_tokens_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table reimbursement_files
-- ----------------------------
ALTER TABLE "public"."reimbursement_files" ADD CONSTRAINT "reimbursement_files_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table reimbursements
-- ----------------------------
ALTER TABLE "public"."reimbursements" ADD CONSTRAINT "reimbursements_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "users_nip_unique" UNIQUE ("nip");

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "users_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table reimbursement_files
-- ----------------------------
ALTER TABLE "public"."reimbursement_files" ADD CONSTRAINT "reimbursement_files_reimbursement_id_foreign" FOREIGN KEY ("reimbursement_id") REFERENCES "public"."reimbursements" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

-- ----------------------------
-- Foreign Keys structure for table reimbursements
-- ----------------------------
ALTER TABLE "public"."reimbursements" ADD CONSTRAINT "reimbursements_user_id_foreign" FOREIGN KEY ("user_id") REFERENCES "public"."users" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;
