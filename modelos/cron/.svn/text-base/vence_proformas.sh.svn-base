#!/bin/bash
psql -d "refeciv" -U postgres -c "SELECT 002.vence_proforma('`date +%Y-%m-%d -d "-15 day"`','`date +%Y-%m-%d`','`date +%H:%M:%S`' )"

// -d es la base de datos
// -u es el usuario
// -c la sentencia que va a ejecutar
// `date +%Y-%m-%d -d "-15 day"` esta fecha la toma del sistema