# Project Architecture

## Overview

- Internal app, Domain Name Team — manage domain registrations under Domain.go.id (Registrar)
- Indonesian only, locale `id_ID`
- No Node.js runtime — NPM for package manager + build only
- UI: white bg, dark blue base, light blue accent, formal typography

## Development Flow

Strict order — no skip, no reverse:

1. Database (raw queries first, minimize magic)
2. Config
3. Model
4. Service (sync-first, avoid queues unless necessary)
5. Controller (separate API + View handlers)
6. Transport: REST (JSON) + HTML (Blade)

## Authentication

- Login: username + password
- Email verification: stub now, activate when production-ready

## AI Agent Instructions

- Use installed `$caveman` or /caveman plugin
- Start features from database layer up
- No unrequested boilerplate
- One file per instruction unless asked otherwise
- Code comments in Indonesian

## Owner Rules

- This file = primary owner instruction. Conflicts → ask before changing important files.
- DB = source of truth. No schema changes on populated tables unless owner asks.
- Data migration: export/import first, never truncate/recreate used tables.
- Model follows real DB schema, not Laravel defaults.
- Add relationships only when clear from schema or owner confirms.
- No boilerplate, services, tests, or new layers unless requested.
- Keep changes small, targeted, backward-compatible.
