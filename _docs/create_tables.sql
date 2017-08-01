CREATE TABLE "item" (
	"item_id" serial NOT NULL,
	"label" varchar(400) NOT NULL,
	CONSTRAINT item_pk PRIMARY KEY ("item_id")
) WITH (
  OIDS=FALSE
);



CREATE TABLE "subitem" (
	"subitem_id" serial NOT NULL,
	"item_id" integer NOT NULL,
	"label" varchar(400) NOT NULL,
	CONSTRAINT subitem_pk PRIMARY KEY ("subitem_id")
) WITH (
  OIDS=FALSE
);



CREATE TABLE "response" (
	"response_id" serial NOT NULL,
	"response_uid" varchar(200) NOT NULL,
	"subitem_id" integer NOT NULL,
	"subitem_actual" integer NOT NULL,
	"subitem_desirable" integer NOT NULL,
	CONSTRAINT response_pk PRIMARY KEY ("response_id")
) WITH (
  OIDS=FALSE
);




ALTER TABLE "subitem" ADD CONSTRAINT "subitem_fk0" FOREIGN KEY ("item_id") REFERENCES "item"("item_id");

ALTER TABLE "response" ADD CONSTRAINT "response_fk0" FOREIGN KEY ("subitem_id") REFERENCES "subitem"("subitem_id");

