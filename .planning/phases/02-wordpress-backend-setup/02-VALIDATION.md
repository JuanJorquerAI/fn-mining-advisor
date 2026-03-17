---
phase: 2
slug: wordpress-backend-setup
status: draft
nyquist_compliant: false
wave_0_complete: false
created: 2026-03-17
---

# Phase 2 — Validation Strategy

> Per-phase validation contract for feedback sampling during execution.

---

## Test Infrastructure

| Property | Value |
|----------|-------|
| **Framework** | wp-cli + curl (CLI-based REST verification) |
| **Config file** | none — manual CLI verification |
| **Quick run command** | `curl -s https://{domain}/wp-json/wp/v2/pages?slug=home | python3 -m json.tool | grep acf` |
| **Full suite command** | See Manual-Only Verifications section |
| **Estimated runtime** | ~30 seconds |

---

## Sampling Rate

- **After every task commit:** Run quick REST check for relevant endpoint
- **After every plan wave:** Run full suite (all curl checks below)
- **Before `/gsd:verify-work`:** All success criteria must pass
- **Max feedback latency:** 60 seconds

---

## Per-Task Verification Map

| Task ID | Plan | Wave | Requirement | Test Type | Automated Command | File Exists | Status |
|---------|------|------|-------------|-----------|-------------------|-------------|--------|
| 2-01-01 | 01 | 1 | WP-01 | manual | `curl -s {domain}/wp-json/wp/v2/pages?slug=home` | ❌ W0 | ⬜ pending |
| 2-01-02 | 01 | 1 | WP-02 | manual | `curl -s {domain}/wp-json/wp/v2/users` | ❌ W0 | ⬜ pending |
| 2-02-01 | 02 | 2 | WP-03 | manual | `curl -s {domain}/wp-json/wp/v2/pages?slug=home \| grep '"acf"'` | ❌ W0 | ⬜ pending |
| 2-02-02 | 02 | 2 | WP-04 | manual | CF7 REST endpoint test | ❌ W0 | ⬜ pending |
| 2-03-01 | 03 | 3 | WP-05 | manual | `curl -s {domain}/wp-json/wp/v2/insights` | ❌ W0 | ⬜ pending |

*Status: ⬜ pending · ✅ green · ❌ red · ⚠️ flaky*

---

## Wave 0 Requirements

- [ ] Verify `wp-cli` is available on server or local dev environment
- [ ] Confirm domain/staging URL for curl-based verification

*Note: WordPress setup is infrastructure-heavy with limited automated test coverage. Most verification is REST endpoint curl checks and admin UI confirmation.*

---

## Manual-Only Verifications

| Behavior | Requirement | Why Manual | Test Instructions |
|----------|-------------|------------|-------------------|
| ACF `acf` key appears in pages REST response | WP-03 | WordPress REST output requires live install | `curl -s https://{domain}/wp-json/wp/v2/pages?slug=home \| python3 -m json.tool` — verify `acf` key with all 6 field groups present |
| Users endpoint returns 403 | WP-02 | Security plugin/mu-plugin behavior | `curl -s https://{domain}/wp-json/wp/v2/users` — expect 403 or empty data |
| XML-RPC returns 403 | WP-02 | Server-level security | `curl -s -o /dev/null -w "%{http_code}" https://{domain}/xmlrpc.php` — expect 403 |
| CF7 form submits and emails | WP-04 | Requires live email + Resend DNS | POST to `/wp-json/contact-form-7/v1/contact-forms/{id}/feedback`, check inbox |
| Insights CPT endpoint returns posts | WP-05 | Requires seeded content | `curl -s https://{domain}/wp-json/wp/v2/insights` — expect array with posts |
| Rank Math Organization schema active | WP-06 | Admin UI check | Log into WP admin → Rank Math → check schema type set to Organization |
| WP admin URL is not `/wp-admin/` | WP-02 | Custom login URL plugin | Navigate to `/wp-admin/` — expect 404 or redirect |

---

## Validation Sign-Off

- [ ] All tasks have `<automated>` verify or Wave 0 dependencies
- [ ] Sampling continuity: no 3 consecutive tasks without automated verify
- [ ] Wave 0 covers all MISSING references
- [ ] No watch-mode flags
- [ ] Feedback latency < 60s
- [ ] `nyquist_compliant: true` set in frontmatter

**Approval:** pending
