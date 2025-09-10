import React, {Suspense, useRef} from "react";
import {Canvas} from "@react-three/fiber";
import {Html, OrbitControls, useGLTF} from "@react-three/drei";


// Simple Model component that loads a GLB/GLTF using useGLTF.
// Pass a URL string in the `src` prop (can be public/remote URL).
function Model({src, scale = 1, position = [0, 0, 0]}) {
// useGLTF caches loaded models so repeated mounts are fast.
    const {scene} = useGLTF(src, true);


    return <primitive object={scene} scale={scale} position={position}/>;
}


// Loader fallback shown while the GLB is loading.
function LoaderFallback() {
    return (
        <Html>
            <div className="p-2 bg-white/90 rounded shadow text-sm whitespace-nowrap">Loading model…</div>
        </Html>
    );
}


// Default export: a full component wrapping Canvas and OrbitControls.
export default function HouseGenerator({
                                           wire,
                                           budget_estimate,
                                           model = '',
                                           background = "#e6eef6",
                                           modelScale = 1,
                                       }) {
    const controlsRef = useRef();


    return (
        <div className="rounded overflow-hidden h-[75vh]">
            <Canvas
                style={{background}}
            >
                {/* Lighting */}
                <ambientLight intensity={0.6}/>
                <directionalLight position={[5, 10, 7]} intensity={1}/>


                <Suspense fallback={<LoaderFallback/>}>
                    {/* The model; scale/position can be adjusted via props. */}
                    <Model src={model} scale={modelScale} position={[0, 0, 0]}/>
                </Suspense>


                {/* Orbit controls allow pan/zoom/rotate. */}
                <OrbitControls
                    ref={controlsRef}
                />
            </Canvas>
        </div>
    );
}
