import type { User } from './auth';

export interface GeneratedIdea {
    id: number;
    created_at: string;
    updated_at: string;
    user_id: number;
    startup_name: string;
    summary: string;
    investor_pitch: string;
    model: string;
    public: boolean;
    price_tiers: GeneratedIdeaPriceTier[];
    testimonials: GeneratedIdeaTestimonial[];
    user: User;
}

export interface GeneratedIdeaPriceTier {
    id: number;
    created_at: string;
    updated_at: string;
    generated_ideas_id: number;
    name: string;
    price_cents: number;
    description?: string;
}

export interface GeneratedIdeaTestimonial {
    id: number;
    created_at: string;
    updated_at: string;
    generated_ideas_id: number;
    author: string;
    comment: string;
}
