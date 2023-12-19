package src

import (
	"database/sql"
	"log"

	_ "github.com/jmrobles/h2go"
)

func Connect() *sql.DB {
	conn, err := sql.Open("h2", "h2://sa@localhost/testdb?mem=true")
	if err != nil {
		log.Fatalf("Can't connet to H2 Database: %s", err)
	}

	err = conn.Ping()
	if err != nil {
		log.Fatalf("Can't ping to H2 Database: %s", err)
	}

	log.Printf("H2 Database connected")

	return conn
}

func insert(conn *sql.DB, table string, data any) {
	panic("Not implemented")
}

func del(conn *sql.DB, uuid string) {
	panic("Not implemented")
}

func createPaymentsTable(conn *sql.DB) {
	// TODO: read migrations file
	panic("Not implemented")
}
