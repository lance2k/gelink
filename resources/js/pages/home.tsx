import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { type SharedData } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { Copy, LoaderCircle } from 'lucide-react';
import { FormEventHandler, useState } from 'react';

type ShortenLinkForm = {
    longUrl: string;
    customizedLink: string;
};

export default function Welcome() {
    const { auth, flash } = usePage<SharedData & { flash: { success?: boolean; shortUrl?: string; error?: string } }>().props;
    const [showResult, setShowResult] = useState(!!flash.success);

    const { data, setData, post, processing, errors, reset } = useForm<Required<ShortenLinkForm>>({
        longUrl: '',
        customizedLink: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('links.store'), {
            onSuccess: () => {
                reset('customizedLink', 'longUrl');
                setShowResult(true);
            },
        });
    };

    return (
        <>
            <Head title="GeLink - Shorten your links">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
                <header className="mb-6 w-full max-w-lg text-sm not-has-[nav]:hidden lg:max-w-4xl">
                    <nav className="flex items-center justify-end gap-4">
                        {auth.user ? (
                            <Link
                                href={route('dashboard')}
                                className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                            >
                                Dashboard
                            </Link>
                        ) : (
                            <>
                                <Link
                                    href={route('login')}
                                    className="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                                >
                                    Log in
                                </Link>
                                <Link
                                    href={route('register')}
                                    className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                                >
                                    Register
                                </Link>
                            </>
                        )}
                    </nav>
                </header>
                <div className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                    <main className="flex w-full max-w-lg flex-col-reverse lg:max-w-4xl lg:flex-col">
                        <div className="mx-auto flex w-full flex-col items-center justify-center gap-6 px-6 py-8 lg:items-center lg:justify-center lg:px-12">
                            <h1 className="text-5xl font-bold text-primary">Make every connection count</h1>
                            <p className="text-muted-foreground">
                                Create short links and share them anywhere. Track analytics and manage your links for free.
                            </p>
                        </div>
                        <div className="flex flex-col gap-6">
                            <Card className="rounded-xl">
                                <form className="flex flex-col gap-6 p-4" onSubmit={submit}>
                                    <div className="grid gap-6">
                                        <div className="grid gap-2">
                                            <Label htmlFor="longUrl">Paste a long URL</Label>
                                            <Input
                                                id="longUrl"
                                                type="url"
                                                required
                                                autoFocus
                                                tabIndex={1}
                                                autoComplete="longUrl"
                                                value={data.longUrl}
                                                onChange={(e) => setData('longUrl', e.target.value)}
                                                placeholder="Enter a long URL to shorten it"
                                            />
                                            <InputError message={errors.longUrl} />
                                        </div>

                                        <div className="grid gap-2">
                                            <Label htmlFor="password">Customize your link</Label>
                                            <Input
                                                id="customizedLink"
                                                type="text"
                                                tabIndex={2}
                                                autoComplete="customizedLink"
                                                value={data.customizedLink}
                                                onChange={(e) => setData('customizedLink', e.target.value)}
                                                placeholder="Enter alias (optional)"
                                            />
                                            <InputError message={errors.customizedLink} />
                                        </div>

                                        <Button type="submit" className="mt-4 w-full" tabIndex={4} disabled={processing}>
                                            {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                                            Shorten URL
                                        </Button>
                                    </div>

                                    {(flash.success && showResult) && (
                                        <div className="mt-4 flex flex-col gap-4 rounded-lg border border-green-200 bg-green-50 p-4 dark:border-green-900 dark:bg-green-950">
                                            <p className="text-sm text-green-600 dark:text-green-400">
                                                Your shortened URL is ready!
                                            </p>
                                            <div className="flex items-center gap-2">
                                                <Input
                                                    readOnly
                                                    value={flash.shortUrl || ''}
                                                    className="bg-white dark:bg-black"
                                                />
                                                <Button
                                                    type="button"
                                                    variant="outline"
                                                    size="icon"
                                                    onClick={() => {
                                                        navigator.clipboard.writeText(flash.shortUrl || '');
                                                    }}
                                                >
                                                    <Copy className="h-4 w-4" />
                                                </Button>
                                            </div>
                                        </div>
                                    )}                                    <div className="text-center text-sm text-muted-foreground">
                                        Don't have an account?{' '}
                                        <TextLink href={route('register')} tabIndex={3}>
                                            Sign up
                                        </TextLink>
                                    </div>
                                </form>
                            </Card>
                        </div>
                    </main>
                </div>
                <div className="hidden h-14.5 lg:block"></div>
            </div>
        </>
    );
}
