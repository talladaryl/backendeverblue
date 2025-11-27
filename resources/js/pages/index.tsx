import { useMemo, useState } from "react";
import { useNavigate } from "react-router-dom";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Separator } from "@/components/ui/separator";
import { cn } from "@/lib/utils";
import { Home, Plus, Mail, HelpCircle, Inbox, Smartphone, LogOut } from "lucide-react";
import BuilderModal from "@/components/BuilderModal";

type Design = {
  id: number;
  title: string;
  description: string;
  palette: string[];
};

const DESIGNS: Design[] = [
  { id: 1, title: "Dazzling Dress Invitation", description: "Invitation élégante pour quinceañera avec robe scintillante.", palette: ["#2C2C54", "#EA2027", "#FDA7DC"] },
  { id: 2, title: "Golden Wedding", description: "Modèle élégant doré pour mariages classieux.", palette: ["#FFC312", "#C4E538", "#12CBC4"] },
  { id: 3, title: "Design Tropical", description: "Modèle élégant avec des feuilles tropicales.", palette: ["#00B894", "#00cec9", "#ffeaa7"] },
  { id: 4, title: "Fête d'été", description: "Invitation vibrante pour une fête d'été.", palette: ["#FDCB6E", "#EE5A24", "#2C3A47"] },
  { id: 5, title: "Design Classique", description: "Invitation sobre et élégante pour tout événement.", palette: ["#B2BEC3", "#636E72", "#2D3436"] },
  { id: 6, title: "Jungle Urbaine", description: "Thème moderne avec motifs de plantes et d'animaux.", palette: ["#00B894", "#60A3BC", "#A29BFE"] },
];

const Index = () => {
  const [query, setQuery] = useState("");
  const [openBuilder, setOpenBuilder] = useState(false);
  const navigate = useNavigate();

  const filtered = useMemo(() => {
    const q = query.toLowerCase();
    return DESIGNS.filter((d) => d.title.toLowerCase().includes(q) || d.description.toLowerCase().includes(q));
  }, [query]);

  return (
    <div className="min-h-screen grid md:grid-cols-[260px_1fr]">
      {/* Sidebar */}
      <aside className="hidden md:flex md:flex-col md:gap-4 p-6 border-r bg-sidebar text-sidebar-foreground">
        <div className="text-2xl font-bold tracking-tight">Everblue</div>
        <nav className="space-y-1">
          <a className="flex items-center gap-3 rounded-md px-3 py-2 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground transition">
            <Home size={18} /> Mes invitations
          </a>
          <a className="flex items-center gap-3 rounded-md px-3 py-2 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground transition">
            <Plus size={18} /> Parcourir mes designs
          </a>
          <a className="flex items-center gap-3 rounded-md px-3 py-2 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground transition">
            <Mail size={18} /> Mes messages
            <span className="ml-auto text-xs rounded-full px-2 py-0.5 bg-destructive text-destructive-foreground">4</span>
          </a>
          <a className="flex items-center gap-3 rounded-md px-3 py-2 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground transition">
            <HelpCircle size={18} /> Centre d’aide
          </a>
          <a className="flex items-center gap-3 rounded-md px-3 py-2 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground transition">
            <Inbox size={18} /> Invitations reçues
          </a>
          <a className="flex items-center gap-3 rounded-md px-3 py-2 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground transition">
            <Smartphone size={18} /> Site mobile
          </a>
        </nav>
        <div className="mt-auto">
          <Separator className="my-4" />
          <button className="flex items-center gap-3 rounded-md px-3 py-2 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground transition w-full">
            <LogOut size={18} /> Déconnexion
          </button>
        </div>
      </aside>

      {/* Main */}
      <main className="p-6">
        <header className="mb-6">
          <h1 className="text-3xl font-bold">Galerie de designs d'invitations</h1>
          <p className="text-muted-foreground mt-1">Choisissez un modèle, personnalisez couleurs et polices, puis envoyez avec suivi RSVP.</p>
        </header>

        <div className="mb-6">
          <Input
            placeholder="Rechercher un design, événement, thème..."
            value={query}
            onChange={(e) => setQuery(e.target.value)}
          />
        </div>

        <section className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {filtered.map((d) => (
            <article key={d.id} className="group rounded-lg border bg-card hover:shadow-md transition-shadow hover-scale overflow-hidden">
              <div className="h-40 w-full" style={{ background: "var(--gradient-primary)" }} />
              <div className="p-4">
                <h3 className="font-semibold text-lg">{d.title}</h3>
                <p className="text-sm text-muted-foreground mt-1">{d.description}</p>
                <div className="mt-3 flex gap-2">
                  {d.palette.map((c) => (
                    <span key={c} className="h-4 w-4 rounded-full border" style={{ background: c }} />
                  ))}
                </div>
              </div>
            </article>
          ))}

          {/* Create your own design card */}
          <article
            className={cn(
              "rounded-lg border bg-card p-6 flex items-center justify-center text-center cursor-pointer hover:shadow-md transition-shadow hover-scale",
              "relative overflow-hidden"
            )}
            onClick={() => navigate("/builder")}
            aria-label="Créer votre propre design"
          >
            <div className="absolute inset-0 opacity-20" style={{ background: "var(--gradient-primary)" }} />
            <div className="relative z-10">
              <Plus className="mx-auto mb-3" />
              <h3 className="font-semibold">Créer votre propre design</h3>
              <p className="text-sm text-muted-foreground">Commencez à partir de zéro</p>
            </div>
          </article>
        </section>
      </main>

      {/* Builder Modal (facultatif, conservé) */}
      {/* <BuilderModal open={openBuilder} onOpenChange={setOpenBuilder} /> */}

      {/* Structured Data */}
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: JSON.stringify({
            '@context': 'https://schema.org',
            '@type': 'ItemList',
            itemListElement: DESIGNS.map((d, i) => ({ '@type': 'ListItem', position: i + 1, name: d.title })),
          }),
        }}
      />
    </div>
  );
};

export default Index;
