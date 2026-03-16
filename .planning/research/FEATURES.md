# Feature Research

**Domain:** B2B Senior Mining/Metallurgical Consultancy Corporate Landing Page
**Researched:** 2026-03-16
**Confidence:** MEDIUM (training data + project context; live web research unavailable in this session)

---

## Context

This is a single-page long-form landing page for a senior individual consultant (FN Mining Advisor / Nuñez Mining Consulting) targeting mining companies and projects in Chile and Latin America. The primary conversion goal is **first contact** — phone call or email inquiry. The audience is technical decision-makers: mine owners, project managers, metallurgical engineers, and procurement teams at mid-to-large mining operations.

Trust is the core conversion driver. B2B mining is a high-stakes, relationship-driven sector where credibility is established through credentials, track record, and demonstrated technical depth — not marketing claims.

---

## Feature Landscape

### Table Stakes (Visitors Expect These)

Features that B2B mining decision-makers expect to find. Missing any of these signals unprofessionalism and destroys trust instantly.

| Feature | Why Expected | Complexity | Notes |
|---------|--------------|------------|-------|
| **Professional hero section with clear value proposition** | First-impression filter: visitors decide within 5 seconds whether they're in the right place | LOW | Needs headline (what you do), subheadline (for whom, where), and 2 CTAs. Full-bleed image or video background with overlay. |
| **Named consultant profile with photo** | B2B professional services is sold person-to-person — anonymity kills trust. Mining culture is relationship-driven. | LOW | Photo (professional headshot), name, credentials (degrees, certifications), years of experience, short bio. Essential for a senior individual consultant vs. a firm. |
| **Explicit service list with descriptions** | Visitors need to know immediately if the consultant does what they need | MEDIUM | Cards or sections per service area. Each should state what it is, who it's for, and what the deliverable looks like. |
| **Geographic scope (Latin America / Chile)** | Mining projects are location-specific; regulatory/geological knowledge is regional | LOW | Stated explicitly in copy or map element. Reassures that the consultant knows Chilean/LatAm regulatory frameworks, SERNAGEOMIN, etc. |
| **Contact form** | Primary conversion mechanism. Expected on every professional services site. | LOW | Name, company, email, phone, service type, message. WhatsApp link as secondary (very common in LatAm B2B). |
| **Contact details visible** | Email and/or phone number in header/footer — not just a form | LOW | In LatAm B2B, a real phone number (preferably Chilean mobile with +56 prefix) signals legitimacy more than almost anything else. |
| **Mobile responsiveness** | 40-60% of initial B2B research happens on mobile in LatAm | MEDIUM | Not just "works on mobile" — must look intentional and professional. Navigation collapses to hamburger. |
| **Language: Spanish** | Target market is Chilean/LatAm companies. English-only signals misalignment. | LOW | Primary language must be Spanish. English version optional/future. |
| **Professional visual design (not template-looking)** | Mining companies deal with large contracts. A low-quality site signals low-quality work. | MEDIUM | The graphite/gold palette and custom Cormorant+Inter typography already differentiate from generic WordPress themes. |
| **About/Who We Are section** | B2B buyers need to know the person behind the services | LOW | Covers background, specialization, sector focus. Should feel authoritative, not marketing-speak. |
| **SEO basics: meta title, description, H1** | Discoverable when companies search for "consultor metalúrgico Chile" etc. | LOW | Basic on-page SEO — no deep technical SEO needed at launch. Schema.org Organization markup is a plus. |
| **Fast load time** | Mining engineers are impatient; slow sites signal poor technical competence (ironic but real) | MEDIUM | No heavy JS frameworks, no unoptimized images. Target <3s on 4G mobile. Vanilla JS stack already aligned. |

---

### Differentiators (Competitive Advantage)

Features that most mining consultancy sites do NOT have, or do poorly. These are where this site can stand out for the target audience.

| Feature | Value Proposition | Complexity | Notes |
|---------|-------------------|------------|-------|
| **Explicit methodology section (NDA → Diagnóstico → Propuesta → Ejecución)** | Reduces perceived risk: "I know exactly what working with this person looks like." Most consultants don't show their process. | LOW | Step-by-step visual treatment. Each step should mention what the client receives. The NDA step first is particularly smart — it signals professionalism and confidentiality-consciousness, very valued in mining M&A contexts. |
| **Confidentiality emphasis ("NDA from day one")** | Mining projects are sensitive. Due diligence, asset valuations, and process IP are highly confidential. Naming this explicitly is a strong trust signal. | LOW | A sentence or callout block. "Confidencialidad desde el primer contacto." Rare to see stated upfront. |
| **Technical content / Insights section (future articles from WP)** | Demonstrates intellectual authority vs. just listing credentials. Mining engineers trust people who share real technical thinking. | MEDIUM | Placeholder section at launch. Feeds from WP REST API. 2-3 article cards max. The value is signaling "this person writes and thinks publicly" — builds SEO over time too. |
| **Specific technical specializations called out** | "Mining consultant" is vague. "Senior metallurgical engineer specializing in comminution, flotation, and mineral valuation" is credible. | LOW | Should name specific process areas: grinding circuits, flotation, leaching, SX-EW, geometallurgy, NI 43-101 valuations, etc. Specificity = expertise. |
| **Innovation and sustainability positioning (technical, not greenwashed)** | ESG requirements are increasingly a procurement criterion for mining projects. Positioned as technical advantage, not marketing. | LOW | Sober, technical language. Not "we care about the planet" but "optimization methodology reduces reagent consumption and energy per tonne." |
| **"Diagnóstico inicial" CTA (not generic "contact us")** | Specific offer reduces friction. "Free initial consultation" or "Initial diagnosis" converts better than generic contact buttons in B2B. | LOW | Changes the CTA from a form to a conversation. Works with the methodology that already starts with diagnosis. |
| **Professional credential badges / logos** | Institutional affiliations, university logos, certification logos add instant credibility. | LOW | If consultant has Universidad de Chile, PUC, SME, AIMMGM, or AusIMM credentials, these logos in a row provide social proof at a glance. |
| **Client logos section (even anonymous)** | "Companies I've worked with" — even unnamed logos (pending NDAs) add social proof | LOW | Can be done as "Sectores atendidos" with company-type icons if specific logos not available. |
| **Bilingual capability signal** | Many mining projects in LatAm involve English-language reports (NI 43-101, JORC). Signaling English proficiency serves foreign-invested projects. | LOW | One sentence in the consultant bio. Does not require an English version of the site at launch. |
| **WhatsApp contact link** | In LatAm B2B, WhatsApp is a legitimate and expected business communication channel. Many engineers prefer it over email for initial contact. | LOW | Floating WhatsApp button or explicit link. Very low effort, high impact for LatAm market specifically. |
| **Schema markup: Person + Organization** | Helps Google associate the consultant's name with the domain for branded searches | LOW | Person schema with credentials, Organization schema with contact info. Takes 30 minutes to implement. |

---

### Anti-Features (Do NOT Build These)

Features that seem like good ideas but would actively harm trust, performance, or scope for this specific site and audience.

| Feature | Why Requested | Why Problematic | Alternative |
|---------|---------------|-----------------|-------------|
| **Generic stock photos of miners** | "Makes it look like a mining site" | Instantly signals inauthenticity. Mining engineers know what their industry looks like — fake stock images destroy credibility faster than no images. | Use abstract geological/metallurgical imagery, real equipment shots if available, or professional headshot-focused layout. Dark graphite with gold accents can carry sections where images aren't available. |
| **Chat widget (Intercom, Drift, etc.)** | "Modern, increases engagement" | Wrong persona. Mining decision-makers are not consumer shoppers. A chatbot on a senior consultant's page feels cheap and signals volume operation, not senior relationship. | Use WhatsApp link and contact form. Personal, async, high-trust channels. |
| **Testimonials carousel / rotating slider** | "Social proof" | Carousels are consistently shown to have near-zero interaction rates. In mining B2B, anonymous rotating quotes are not trusted. | Static testimonials with name + company + role (with permission), or case study summaries. |
| **Animation-heavy entry effects** | "Modern and dynamic" | Mining engineers are conservative, analytical people. Heavy animations signal "marketing agency" not "technical expert." Also harms performance and accessibility. | Subtle scroll reveals (fade-in), one parallax effect on hero max. The content and design quality must do the work, not motion. |
| **News feed / Twitter/X feed embed** | "Shows activity" | Third-party social feeds slow down load times, look cheap, and Twitter/X brand association is now a liability in professional contexts. | Link to LinkedIn profile. Curated Insights section fed from WP with real articles. |
| **E-commerce / automatic quote calculator** | "Self-service for clients" | Mining consultancy scope and pricing cannot be automated — every project is unique. A calculator signals junior/commoditized service. | The "Diagnóstico inicial" CTA. Conversation first. |
| **Blog with high posting frequency requirement** | "SEO and thought leadership" | Sets a maintenance expectation the consultant cannot sustain. Empty or stale blog (last post 18 months ago) is worse than no blog. | Insights section with 2-4 high-quality annual articles. Quality over frequency. WP REST API already planned for this. |
| **Cookie consent popup (GDPR-style)** | Legal compliance instinct | Chile's data protection law (Ley 19.628) does not require GDPR-style popups for simple contact forms. A popup creates friction on first impression. | No analytics cookies at launch. If Google Analytics added later, use cookieless (GA4 measurement without cookies) or add minimal notice in footer. |
| **Social media sharing buttons** | "Viral content" | Mining B2B content is not shared on social media by decision-makers. These buttons add visual clutter and signal B2C thinking. | LinkedIn share link on articles, nothing else. |
| **"Our Team" section with multiple people** | "Signals scale" | This is a solo senior consultant. A fake team section will be exposed immediately in conversations and destroys trust. | Emphasize depth of one senior expert vs. breadth of a junior firm. "Senior expertise, not junior delegation." |
| **Pricing page** | "Transparency" | Mining consultancy pricing is project-dependent and relationship-negotiated. Publishing rates devalues the service and starts price competition before value is established. | "Cotización a medida" — custom quote after initial diagnosis. |

---

## Feature Dependencies

```
Hero Section
    └──requires──> Clear Value Proposition (copy)
                       └──requires──> Defined Service Areas

Contact Form
    └──requires──> Contact Destination (email/webhook)
    └──enhances──> WhatsApp Link (dual channel)

Insights / Articles Section
    └──requires──> WordPress REST API Integration
                       └──requires──> WordPress Setup + ACF
                       └──requires──> Custom Post Type: articles/insights

Credential Badges
    └──requires──> Consultant Profile Section (anchor for context)

Methodology Section
    └──enhances──> Contact Form CTA ("Start with your diagnosis")
    └──enhances──> Trust / Confidentiality signal

Technical Specializations
    └──enhances──> Services Section (specificity per service)
    └──enhances──> Hero Subheadline

Services Section
    └──enhances──> Individual Service CTAs → Contact Form
```

### Dependency Notes

- **Insights Section requires WordPress**: This is the only section with a hard technical dependency. Everything else can be static HTML at launch. The WP REST API integration is the architectural complexity point.
- **Contact Form requires a working email destination**: Trivial but often missed — needs SMTP or a form service (Formspree, Web3Forms) configured before launch.
- **Methodology enhances trust CTAs**: The NDA step in the methodology makes the "contact us" CTA less scary — the visitor knows confidentiality is protected from step one. These two sections should be placed in proximity or the CTA should reference the methodology.
- **Credential Badges require real assets**: Logo files from universities/certifications must be sourced from the consultant. Cannot placeholder these.

---

## MVP Definition

### Launch With (v1)

Minimum required to establish trust and capture first contact inquiries.

- [ ] **Hero section** — Headline, subheadline, 2 CTAs (contact + services anchor)
- [ ] **Named consultant profile with photo and credentials** — Non-negotiable for B2B trust
- [ ] **4 Service descriptions** — What each service is, who it's for, expected deliverable
- [ ] **Methodology section (4 steps)** — Reduces perceived risk for first contact
- [ ] **Contact form + contact details** — Primary conversion element
- [ ] **WhatsApp link** — Secondary conversion element, high impact in LatAm
- [ ] **Mobile-responsive design** — Required, not optional
- [ ] **Spanish language** — Required for target market
- [ ] **Basic SEO metadata** — Title, description, H1/H2 hierarchy, Organization schema
- [ ] **Insights section (placeholder, 2-3 static cards)** — WP integration ready but not required for launch

### Add After Validation (v1.x)

Add once the site is live and receiving traffic.

- [ ] **WordPress REST API for dynamic content** — When consultant has articles to publish
- [ ] **Client logos or "Sectores atendidos"** — When permissions secured or alternatives designed
- [ ] **Credential/institutional logos** — When asset files received from consultant
- [ ] **Bilingual capability (English)** — If inquiries from foreign-invested projects materialize
- [ ] **Google Analytics (cookieless)** — When traffic volume justifies measurement

### Future Consideration (v2+)

Defer until product-market fit and business volume are established.

- [ ] **Case studies / project portfolios** — When confidentiality allows and examples are documented
- [ ] **Training / Capacitaciones section** — As a business line, not just a placeholder
- [ ] **Separate service landing pages** — When SEO warrants individual pages per service
- [ ] **CRM integration** — When inquiry volume requires pipeline management
- [ ] **Newsletter / content subscription** — When Insights section has enough content velocity

---

## Feature Prioritization Matrix

| Feature | Visitor Value | Implementation Cost | Priority |
|---------|---------------|---------------------|----------|
| Hero + value proposition | HIGH | LOW | P1 |
| Named consultant profile + photo | HIGH | LOW | P1 |
| Contact form + contact details | HIGH | LOW | P1 |
| Service descriptions (4 areas) | HIGH | LOW | P1 |
| Methodology section | HIGH | LOW | P1 |
| Mobile responsiveness | HIGH | MEDIUM | P1 |
| WhatsApp link | HIGH | LOW | P1 |
| Basic SEO metadata + schema | MEDIUM | LOW | P1 |
| Insights section (placeholder) | MEDIUM | LOW | P1 |
| WordPress REST API integration | MEDIUM | HIGH | P2 |
| Credential/institutional logos | MEDIUM | LOW (if assets exist) | P2 |
| Confidentiality emphasis callout | MEDIUM | LOW | P1 |
| Innovation/sustainability block | LOW | LOW | P2 |
| Client logos / sectors served | MEDIUM | LOW | P2 |
| Bilingual signal in bio | LOW | LOW | P2 |
| Google Analytics | LOW | LOW | P3 |
| Full English version | LOW | HIGH | P3 |
| Case studies | HIGH | HIGH | P3 |

---

## Competitor Feature Analysis

Based on known patterns for mining consultancy and professional services sites in the LatAm market. Live verification was not available in this research session.

| Feature | Typical Mining Consultancy (LatAm) | Large Mining Company Site | Our Approach |
|---------|-------------------------------------|---------------------------|--------------|
| Consultant photo + bio | Often missing or generic | Executive team page | Named, prominent, personal — this IS the product |
| Service list | Bulleted lists, generic | Corporate divisions | Cards with specific technical descriptions and CTAs |
| Methodology | Rarely shown | Internal processes | 4-step visible process starting with NDA |
| Confidentiality stated | Almost never | Legal boilerplate | Prominent, first-contact guarantee |
| Technical depth in copy | Marketing language | Corporate language | Metallurgical specifics (comminution, flotation, etc.) |
| Contact CTA | "Contact us" generic | Press relations | "Request your initial diagnosis" — specific offer |
| WhatsApp | Rare on "professional" sites | Never | Explicit channel — LatAm B2B reality |
| Insights / Articles | Absent or abandoned blog | Corporate news | Curated, high-quality, sporadic — quality over frequency |
| Visual design quality | Cheap themes, template look | Enterprise CMS | Custom premium — graphite/gold positions as senior |

---

## Sources

- PROJECT.md context (FN Mining Advisor project requirements, 2026-03-16)
- Training data: B2B professional services website conversion best practices (knowledge through August 2025)
- Training data: Mining industry digital presence patterns in Chile and Latin America
- Training data: LatAm B2B contact preferences and communication norms (WhatsApp usage)
- Training data: Chilean data protection law (Ley 19.628) — LOW confidence, verify before implementation
- Reference sites named in PROJECT.md: Gold Fields, Mettest/McClelland Laboratories, Mercado Minero (not verified live — access restricted during research session)

**Confidence notes:**
- Table stakes features: HIGH confidence — these are well-established B2B trust patterns
- Differentiators: MEDIUM confidence — specific to mining sector, based on training data not live audit
- Anti-features: HIGH confidence — based on well-documented B2B UX research patterns
- LatAm-specific norms (WhatsApp, Spanish primary): HIGH confidence — well established
- Legal compliance (Ley 19.628): LOW confidence — verify with lawyer before implementation

---

*Feature research for: B2B Senior Mining/Metallurgical Consultancy Corporate Landing Page (FN Mining Advisor)*
*Researched: 2026-03-16*
