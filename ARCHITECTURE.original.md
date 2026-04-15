# Project Architecture

## Overview

- Internal app for Domain Name Team
- Manage domain registrations under Domain.go.id
- Act as domain Registrar
- Indonesian only, locale `id_ID`
- Avoid Node.js runtime — use NPM only as package manager + build tool
- UI color scheme: White (not very white) background, Dark Blue base, Light Blue accent
- Prioritize formal typography

## Development Flow

Follow order strict — no skip, no reverse:

1. Database (write raw queries first, minimize magic + abstraction)
2. Config
3. Model
4. Service (synchronous-first, avoid queues unless absolutely necessary)
5. Controller (separate API handlers and View handlers)
6. Transport: REST (JSON) and HTML (Blade templates)

## Authentication

- Login via username + password
- Email verification: stub now, activate only when production-ready

## AI Agent Instructions

- Always use installed `$caveman` plugin
- Start every feature from database layer before touching above it
- Do not generate unrequested boilerplate
- One file per instruction unless explicitly asked otherwise
- Write all code comments in Indonesian

## Owner Rules

- Ikuti `ARCHITECTURE.md` ini sebagai instruksi utama dari owner.
- Jika ada konflik dengan instruksi lain, minta klarifikasi dulu sebelum ubah file penting.
- Database existing source of truth.
- Jangan ubah schema tabel yang sudah berisi data, kecuali owner minta eksplisit.
- Untuk data migration, export/import dulu, jangan truncate atau recreate tabel yang sudah terpakai.
- Model harus mengikuti schema nyata di database, bukan asumsi default Laravel.
- Relationship hanya tambah kalau jelas dari schema atau konfirmasi owner.
- Jangan tambah boilerplate, service, test, atau layer baru kalau belum diminta.
- Jaga perubahan kecil, terarah, dan kompatibel dengan data lama.
