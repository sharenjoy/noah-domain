# sharenjoy/noah-domain

Shared domain package for Noah projects.

## Current scope

- Migrated models (phase 1): `Post`, `Category`, `Menu`
- Shared traits: `CommonModelTrait`, `HasCategoryTree`, `HasMenus`
- Goal: reusable Eloquent domain layer without Filament UI coupling

## Out of scope in this phase

- Filament Resources/Pages/Plugins
- Panel providers and admin-only UI behaviors
- Admin-specific actions (e.g. replicate action UI)
