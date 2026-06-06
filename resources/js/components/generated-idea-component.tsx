import type { GeneratedIdea } from '@/types/generated_idea';

const lgCols: Record<number, string> = {
    1: 'lg:grid-cols-1',
    2: 'lg:grid-cols-2',
    3: 'lg:grid-cols-3',
    4: 'lg:grid-cols-4',
    5: 'lg:grid-cols-5',
    6: 'lg:grid-cols-6',
};

export default function GeneratedIdeaComponent({
    generated_idea,
}: {
    generated_idea: GeneratedIdea;
}) {
    return (
        <div className="mb-4 space-y-1.5 rounded-md bg-gray-300 p-4 shadow-md shadow-gray-400 dark:bg-gray-700 dark:shadow-gray-800">
            <div className="text-xl underline">
                <strong>{generated_idea.startup_name}</strong>
            </div>
            <div>
                <strong>Summary:</strong>&nbsp;
                {generated_idea.summary}
            </div>
            <div>
                <strong>Investor Pitch:</strong>&nbsp;
                {generated_idea.investor_pitch}
            </div>
            <div>
                <strong>Price Tiers:</strong>
                <div
                    className={`grid grid-cols-1 gap-2 ${lgCols[generated_idea.price_tiers.length]}`}
                >
                    {generated_idea.price_tiers.map((price_tier) => (
                        <div
                            key={price_tier.id}
                            className="mb-1 rounded-sm bg-gray-200 p-2 dark:bg-gray-800"
                        >
                            <strong>{price_tier.name}</strong>: $
                            {(price_tier.price_cents / 100).toFixed(2)}
                            /month
                            <br />
                            <div className="">{price_tier.description}</div>
                        </div>
                    ))}
                </div>
            </div>
            <div>
                <strong>Testimonials:</strong>
                <div className="space-y-2">
                    {generated_idea.testimonials.map((testimonial) => (
                        <div
                            key={testimonial.id}
                            className="rounded-sm bg-gray-200 p-2 dark:bg-gray-800"
                        >
                            "{testimonial.comment}"
                            <br />
                            &mdash; {testimonial.author ?? 'Anonymous'}
                        </div>
                    ))}
                </div>
            </div>
            <div>
                Posted by <strong>{generated_idea.model}</strong> (suggested by{' '}
                <strong>{generated_idea.user.name}</strong>) on{' '}
                {generated_idea.created_at
                    .substring(0, 16)
                    .replace('T', ' at ')}
            </div>
        </div>
    );
}
