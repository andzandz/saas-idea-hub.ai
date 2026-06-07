import { Head, Link } from '@inertiajs/react';
import GeneratedIdeaComponent from '@/components/generated-idea-component';
import { generateIdea, allIdeas } from '@/routes';
import type { GeneratedIdea } from '@/types/generated_idea';

interface DashboardProps {
    generated_ideas: GeneratedIdea[];
}

export default function AllIdeas({ generated_ideas }: DashboardProps) {
    return (
        <>
            <Head title="All Ideas" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="mb-4">
                    {generated_ideas.map((generated_idea) => (
                        <div key={generated_idea.id}>
                            <GeneratedIdeaComponent
                                generated_idea={generated_idea}
                            ></GeneratedIdeaComponent>
                        </div>
                    ))}
                </div>
                <div className="self-center">
                    <Link
                        className={`cursor-pointer rounded-xl bg-green-600 px-4 py-2 text-white dark:bg-green-700`}
                        href={generateIdea()}
                    >
                        Generate idea...
                    </Link>
                </div>
            </div>
        </>
    );
}

AllIdeas.layout = {
    breadcrumbs: [
        {
            title: 'All Ideas',
            href: allIdeas(),
        },
    ],
};
