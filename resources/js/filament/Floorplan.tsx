import React, {useCallback, useMemo, useRef, useState} from "react";
import {motion} from "framer-motion";
import {Download, Grid as GridIcon, Maximize2, Ruler, ZoomIn, ZoomOut} from "lucide-react";

// ===== Types =====
export type Vec = [number, number];
export type Segment = { id?: string; from: Vec; to: Vec; thickness?: number };
export type Room = { id?: string; name?: string; polygon: Vec[]; fill?: string };

export type FloorplanProps = {
    /** World units per meter (1 = meters, 3.28084 = feet) */
    unitsPerMeter?: number;
    /** Pixels per world unit at zoom = 1 */
    pixelsPerUnit?: number;
    /** Optional rooms (polygons) */
    rooms: Room[];
    /** Show grid */
    showGrid?: boolean;
    /** Grid spacing in world units */
    gridStep?: number;
    /** Label units symbol */
    unitLabel?: string; // "m" | "ft"
};

// ===== Utilities =====
const length = (a: Vec, b: Vec) => Math.hypot(b[0] - a[0], b[1] - a[1]);
const midpoint = (a: Vec, b: Vec): Vec => [(a[0] + b[0]) / 2, (a[1] + b[1]) / 2];

// Convert world to screen
function worldToScreen(
    p: Vec,
    zoom: number,
    offset: Vec,
    ppu: number
): Vec {
    // Invert y to get blueprint-style up-axis
    const sx = p[0] * ppu * zoom + offset[0];
    const sy = -p[1] * ppu * zoom + offset[1];
    return [sx, sy];
}

// ===== Grid component =====
function Grid({
                  width,
                  height,
                  zoom,
                  offset,
                  ppu,
                  step,
              }: {
    width: number;
    height: number;
    zoom: number;
    offset: Vec;
    ppu: number;
    step: number;
}) {
    // Determine visible bounds in world space
    const inv = 1 / (ppu * zoom);
    const left = (-offset[0]) * inv;
    const right = (width - offset[0]) * inv;
    const top = (offset[1] - height) * -inv;
    const bottom = offset[1] * -inv;

    const startX = Math.floor(left / step) * step;
    const endX = Math.ceil(right / step) * step;
    const startY = Math.floor(top / step) * step;
    const endY = Math.ceil(bottom / step) * step;

    const lines: JSX.Element[] = [];
    for (let x = startX; x <= endX; x += step) {
        const [sx1, sy1] = worldToScreen([x, startY], zoom, offset, ppu);
        const [sx2, sy2] = worldToScreen([x, endY], zoom, offset, ppu);
        lines.push(
            <line key={`gx-${x}`} x1={sx1} y1={sy1} x2={sx2} y2={sy2} stroke="#e5e7eb" strokeWidth={1}/>
        );
    }
    for (let y = startY; y <= endY; y += step) {
        const [sx1, sy1] = worldToScreen([startX, y], zoom, offset, ppu);
        const [sx2, sy2] = worldToScreen([endX, y], zoom, offset, ppu);
        lines.push(
            <line key={`gy-${y}`} x1={sx1} y1={sy1} x2={sx2} y2={sy2} stroke="#e5e7eb" strokeWidth={1}/>
        );
    }

    return <g>{lines}</g>;
}

// ===== Dimension label for a segment =====
function Dimension({a, b, zoom, offset, ppu, unitLabel}: {
    a: Vec;
    b: Vec;
    zoom: number;
    offset: Vec;
    ppu: number;
    unitLabel: string;
}) {
    const L = length(a, b);
    const mid = midpoint(a, b);
    const [sx, sy] = worldToScreen(mid, zoom, offset, ppu);
    const angle = Math.atan2(-(b[1] - a[1]), b[0] - a[0]); // screen space angle
    const text = `${round2(L)} ${unitLabel}`;

    return (
        <g transform={`translate(${sx}, ${sy}) rotate(${(angle * 180) / Math.PI})`}>
            <rect x={-28} y={-12} width={56} height={20} rx={4} ry={4} fill="white" stroke="#94a3b8"/>
            <text x={0} y={3} textAnchor="middle" fontSize={12} fill="#111827"
                  style={{userSelect: "none"}}>
                {text}
            </text>
        </g>
    );
}

const round2 = (n: number) => Math.round(n * 100) / 100;

// ===== Export helpers =====
function downloadSVG(svgEl: SVGSVGElement, name = "floorplan.svg") {
    const serializer = new XMLSerializer();
    const source = serializer.serializeToString(svgEl);
    const blob = new Blob([source], {type: "image/svg+xml;charset=utf-8"});
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = name;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

function downloadPNG(svgEl: SVGSVGElement, name = "floorplan.png", scale = 2) {
    const serializer = new XMLSerializer();
    const source = serializer.serializeToString(svgEl);
    const img = new Image();
    const url = URL.createObjectURL(new Blob([source], {type: "image/svg+xml;charset=utf-8"}));
    img.onload = () => {
        const canvas = document.createElement("canvas");
        canvas.width = svgEl.clientWidth * scale;
        canvas.height = svgEl.clientHeight * scale;
        const ctx = canvas.getContext("2d");
        if (!ctx) return;
        ctx.setTransform(scale, 0, 0, scale, 0, 0);
        ctx.fillStyle = "#ffffff";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0);
        canvas.toBlob((blob) => {
            if (!blob) return;
            const dl = document.createElement("a");
            dl.href = URL.createObjectURL(blob);
            dl.download = name;
            document.body.appendChild(dl);
            dl.click();
            document.body.removeChild(dl);
        });
        URL.revokeObjectURL(url);
    };
    img.src = url;
}

// ===== Main Component =====
export function FloorplanBlueprint({
                                       pixelsPerUnit = 40,
                                       rooms,
                                       gridStep = 0.5,
                                       unitLabel = "m",
                                   }: FloorplanProps) {
    const containerRef = useRef<HTMLDivElement | null>(null);
    const svgRef = useRef<SVGSVGElement | null>(null);
    const walls = generateWallsFromRooms(rooms)
    // Pan & zoom state
    const [zoom, setZoom] = useState(1);
    const [offset, setOffset] = useState<Vec>([700, 400]);
    const [panning, setPanning] = useState(false);
    const panStart = useRef<Vec>([0, 0]);
    const offsetStart = useRef<Vec>([0, 0]);

    const ppu = pixelsPerUnit; // pixels per world unit

    const onWheel = useCallback(
        (e: React.WheelEvent) => {
            const rect = (e.currentTarget as SVGSVGElement).getBoundingClientRect();
            const mouse: Vec = [e.clientX - rect.left, e.clientY - rect.top];
            const delta = -e.deltaY;
            const factor = Math.exp(delta * 0.0015);
            const newZoom = Math.max(0.2, Math.min(6, zoom * factor));

            // zoom about mouse
            const worldBefore: Vec = [
                (mouse[0] - offset[0]) / (ppu * zoom),
                -(mouse[1] - offset[1]) / (ppu * zoom),
            ];
            const newOffset: Vec = [
                mouse[0] - worldBefore[0] * ppu * newZoom,
                mouse[1] + worldBefore[1] * ppu * newZoom,
            ];
            setZoom(newZoom);
            setOffset(newOffset);
        },
        [zoom, offset, ppu]
    );

    const onMouseDown = useCallback((e: React.MouseEvent) => {
        if (e.button !== 0) return;
        setPanning(true);
        panStart.current = [e.clientX, e.clientY];
        offsetStart.current = [...offset];
    }, [offset]);

    const onMouseMove = useCallback((e: React.MouseEvent) => {
        if (!panning) return;
        const dx = e.clientX - panStart.current[0];
        const dy = e.clientY - panStart.current[1];
        setOffset([offsetStart.current[0] + dx, offsetStart.current[1] + dy]);
    }, [panning]);

    const onMouseUp = useCallback(() => setPanning(false), []);

    const bounds = useMemo(() => {
        // compute world bounds of data to center initially (if you wire it)
        const points: Vec[] = [
            ...rooms.flatMap(r => r.polygon),
            ...walls.flatMap(w => [w.from, w.to]),
        ];
        const xs = points.map(p => p[0]);
        const ys = points.map(p => p[1]);
        const minX = Math.min(...xs);
        const maxX = Math.max(...xs);
        const minY = Math.min(...ys);
        const maxY = Math.max(...ys);
        return {minX, maxX, minY, maxY};
    }, [rooms, walls]);

    const fitToView = useCallback(() => {
        const div = containerRef.current;
        const svg = svgRef.current;
        if (!div || !svg) return;
        const pad = 40;
        const w = div.clientWidth - pad * 2;
        const h = div.clientHeight - pad * 2;
        const worldW = bounds.maxX - bounds.minX;
        const worldH = bounds.maxY - bounds.minY;
        const z = Math.max(0.1, Math.min(6, Math.min(w / (worldW * ppu), h / (worldH * ppu))));
        const ox = pad + (w - worldW * ppu * z) / 2 - bounds.minX * ppu * z;
        const oy = pad + (h - worldH * ppu * z) / 2 + bounds.maxY * ppu * z;
        setZoom(z);
        setOffset([ox, oy]);
    }, [bounds, ppu]);

    const handleDownloadSVG = () => svgRef.current && downloadSVG(svgRef.current);
    const handleDownloadPNG = () => svgRef.current && downloadPNG(svgRef.current);

    return (
        <div className="w-full h-[80vh] bg-white flex flex-col border rounded-2xl shadow-sm overflow-hidden">
            {/* Toolbar */}
            <div className="flex items-center gap-2 p-2 border-b bg-gradient-to-b from-gray-50 to-white">
                <button
                    onClick={() => setZoom((z) => Math.min(6, z * 1.2))}
                    className="px-2 py-1 rounded-xl border shadow-sm hover:bg-gray-50 flex items-center gap-1"
                >
                    <ZoomIn className="w-4 h-4"/>
                    Zoom In
                </button>
                <button
                    onClick={() => setZoom((z) => Math.max(0.2, z / 1.2))}
                    className="px-2 py-1 rounded-xl border shadow-sm hover:bg-gray-50 flex items-center gap-1"
                >
                    <ZoomOut className="w-4 h-4"/>
                    Zoom Out
                </button>
                <button
                    onClick={fitToView}
                    className="px-2 py-1 rounded-xl border shadow-sm hover:bg-gray-50 flex items-center gap-1"
                >
                    <Maximize2 className="w-4 h-4"/>
                    Fit
                </button>
                <div className="flex-1"/>
                <div className="text-sm text-gray-500 flex items-center gap-2 pr-2"><Ruler
                    className="w-4 h-4"/> Scale: {pixelsPerUnit} px / {unitLabel}</div>
                <button onClick={handleDownloadSVG}
                        className="px-2 py-1 rounded-xl border shadow-sm hover:bg-gray-50 flex items-center gap-1">
                    <Download className="w-4 h-4"/> SVG
                </button>
                <button onClick={handleDownloadPNG}
                        className="px-2 py-1 rounded-xl border shadow-sm hover:bg-gray-50 flex items-center gap-1">
                    <Download className="w-4 h-4"/> PNG
                </button>
            </div>

            {/* Canvas */}
            <div ref={containerRef} className="relative flex-1">
                <svg
                    ref={svgRef}
                    className="absolute inset-0 w-full h-full touch-none cursor-grab active:cursor-grabbing"
                    onWheel={onWheel}
                    onMouseDown={onMouseDown}
                    onMouseMove={onMouseMove}
                    onMouseUp={onMouseUp}
                    onMouseLeave={onMouseUp}
                >
                    {/* Background */}
                    <rect x={0} y={0} width="100%" height="100%" fill="#ffffff"/>

                    {/* Rooms */}
                    <g>
                        {rooms.map((room, i) => {
                            const screenPoints = room.polygon
                                .map((p) => worldToScreen(p, zoom, offset, ppu))
                                .map((p) => `${p[0]},${p[1]}`)
                                .join(" ");

                            // centroid for label (simple average)
                            const cx = room.polygon.reduce((s, p) => s + p[0], 0) / room.polygon.length;
                            const cy = room.polygon.reduce((s, p) => s + p[1], 0) / room.polygon.length;
                            const [sx, sy] = worldToScreen([cx, cy], zoom, offset, ppu);

                            return (
                                <g key={room.id || i}>
                                    <motion.polygon
                                        points={screenPoints}
                                        fill={room.fill || "#f8fafc"}
                                        stroke="#1f2937"
                                        strokeWidth={1.5}
                                        initial={{opacity: 0}}
                                        animate={{opacity: 1}}
                                        transition={{duration: 0.4, delay: i * 0.04}}
                                    />
                                    {room.name && (
                                        <text x={sx} y={sy} textAnchor="middle" fontSize={13} fill="#111827"
                                              style={{userSelect: "none"}}>
                                            {room.name}
                                        </text>
                                    )}
                                </g>
                            );
                        })}
                    </g>

                    {/* Walls */}
                    <g>
                        {walls.map((w, i) => {
                            const [a, b] = [w.from, w.to];
                            const [sx1, sy1] = worldToScreen(a, zoom, offset, ppu);
                            const [sx2, sy2] = worldToScreen(b, zoom, offset, ppu);
                            const thicknessPx = (w.thickness ?? 0.15) * ppu * zoom;
                            return (
                                <g key={w.id || i}>
                                    <line x1={sx1} y1={sy1} x2={sx2} y2={sy2} stroke="#111827"
                                          strokeWidth={Math.max(2, thicknessPx)} strokeLinecap="round"/>
                                    <Dimension a={a} b={b} zoom={zoom} offset={offset} ppu={ppu} unitLabel={unitLabel}/>
                                </g>
                            );
                        })}
                    </g>

                    {/* Scale bar */}
                    <ScaleBar offset={offset} zoom={zoom} ppu={ppu} unitLabel={unitLabel}/>
                </svg>

                {/* Corner legend */}
                <div
                    className="absolute bottom-3 left-3 bg-white/90 backdrop-blur px-3 py-2 rounded-xl border text-xs text-gray-600 flex items-center gap-2 shadow-sm">
                    <GridIcon className="w-4 h-4"/>
                    <span>Grid: {gridStep} {unitLabel}</span>
                    <span>•</span>
                    <span>Drag to pan • Scroll to zoom</span>
                </div>
            </div>
        </div>
    );
}

function ScaleBar({zoom, ppu, unitLabel}: { offset: Vec; zoom: number; ppu: number; unitLabel: string }) {
    // Pick a nice round distance to show (1, 2, 5, 10 ...)
    const niceSteps = [1, 2, 5];
    let lengthUnits = 1;
    let pixels = ppu * zoom * lengthUnits;
    while (pixels < 80) {
        const idx = niceSteps.indexOf(lengthUnits as any);
        if (idx >= 0 && idx < niceSteps.length - 1) {
            lengthUnits = niceSteps[idx + 1];
        } else {
            lengthUnits *= 2;
        }
        pixels = ppu * zoom * lengthUnits;
    }

    return (
        <g>
            <rect x={16} y={16} width={pixels} height={8} fill="#111827" rx={2} ry={2}/>
            <text x={16 + pixels + 6} y={23} fontSize={12} fill="#111827">
                {lengthUnits} {unitLabel}
            </text>
        </g>
    );
}

export default function Floorplan({budget_estimate}) {
    let rooms: Room[] = convertRooms3Dto2D([
        {
            "position": [
                -2.5,
                1.5,
                -2.5
            ],
            "dimensions": [
                5,
                3,
                5
            ],
            "outerWalls": {
                "front": true,
                "back": false,
                "left": true,
                "right": false
            },
            "internalWalls": {
                "front": false,
                "back": true,
                "left": false,
                "right": true
            },
            "windows": {
                "front": [
                    0,
                    0,
                    -2.4
                ],
                "left": [
                    -2.4,
                    0,
                    0
                ]
            },
            "story": 0
        },
        {
            "position": [
                2.5,
                1.5,
                -2.5
            ],
            "dimensions": [
                5,
                3,
                5
            ],
            "outerWalls": {
                "front": true,
                "back": false,
                "left": false,
                "right": true
            },
            "internalWalls": {
                "front": false,
                "back": true,
                "left": true,
                "right": false
            },
            "windows": {
                "front": [
                    0,
                    0,
                    -2.4
                ],
                "right": [
                    2.4,
                    0,
                    0
                ]
            },
            "story": 0
        },
        {
            "position": [
                0,
                1.5,
                2.5
            ],
            "dimensions": [
                10,
                3,
                5
            ],
            "outerWalls": {
                "front": false,
                "back": true,
                "left": true,
                "right": true
            },
            "internalWalls": {
                "front": true,
                "back": false,
                "left": false,
                "right": false
            },
            "windows": {
                "back": [
                    0,
                    0,
                    2.4
                ],
                "left": [
                    -4.9,
                    0,
                    0
                ],
                "right": [
                    4.9,
                    0,
                    0
                ]
            },
            "story": 0
        }
    ]);

    rooms = [

        {
            "id": "r3",
            "name": "room 3",
            "polygon": [
                [
                    -5,
                    0
                ],
                [
                    5,
                    0
                ],
                [
                    5,
                    5
                ],
                [
                    -5,
                    5
                ]
            ]
        },
        {
            "id": "r2",
            "name": "room 2",
            "polygon": [
                [
                    0,
                    -5
                ],
                [
                    5,
                    -5
                ],
                [
                    5,
                    0
                ],
                [
                    0,
                    0
                ]
            ]
        },
        {
            "id": "r1",
            "name": "room 1",
            "polygon": [
                [
                    -5,
                    -5
                ],
                [
                    0,
                    -5
                ],
                [
                    0,
                    0
                ],
                [
                    -5,
                    0
                ]
            ]
        },

    ];


    return (
        <FloorplanBlueprint
            unitLabel="m"
            pixelsPerUnit={40}
            gridStep={0.5}
            rooms={rooms}
        />
    );
}


type Room2D = {
    id: string;
    name: string;
    polygon: [number, number][];
};

function convertRooms3Dto2D(data: any[]): Room2D[] {
    return data.map((room, i) => {
        const [width, , length] = room.dimensions;  // y is height, ignore
        const [x, , z] = room.position;             // use only x & z

        const halfW = width / 2;
        const halfL = length / 2;

        // rectangle corners in XZ plane
        const polygon: [number, number][] = [
            [x - halfW, z - halfL], // bottom-left
            [x + halfW, z - halfL], // bottom-right
            [x + halfW, z + halfL], // top-right
            [x - halfW, z + halfL], // top-left
        ];

        return {
            id: `r${i + 1}`,
            name: `room ${i + 1}`,
            polygon,
        };
    });
}


// ===== Auto-wall generator =====
function generateWallsFromRooms(rooms: Room[], thickness = 0.15): Segment[] {
    type Key = string;
    const edgeMap = new Map<Key, { from: Vec; to: Vec; count: number }>();

    for (const room of rooms) {
        const pts = room.polygon;
        for (let i = 0; i < pts.length; i++) {
            const a = pts[i];
            const b = pts[(i + 1) % pts.length];
            const key = edgeKey(a, b);
            const revKey = edgeKey(b, a);

            if (edgeMap.has(revKey)) {
                // shared edge
                edgeMap.get(revKey)!.count += 1;
            } else {
                edgeMap.set(key, {from: a, to: b, count: 1});
            }
        }
    }

    return [...edgeMap.values()].map((e, i) => ({
        id: `w${i}`,
        from: e.from,
        to: e.to,
        count: e.count,
        thickness,
    }));
}

// helper: create a unique key for an edge
function edgeKey(a: Vec, b: Vec): string {
    return `${a[0]},${a[1]}-${b[0]},${b[1]}`;
}
